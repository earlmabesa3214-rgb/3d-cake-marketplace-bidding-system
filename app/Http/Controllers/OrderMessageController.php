<?php

namespace App\Http\Controllers;

use App\Models\BakerOrder;
use App\Models\OrderMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrderMessageController extends Controller
{
  public function store(Request $request, BakerOrder $order)
    {
        $user = Auth::user();

        $isCustomer = $order->cakeRequest->user_id === $user->id;
        $isBaker    = $order->baker_id === $user->id;
        abort_if(!$isCustomer && !$isBaker, 403);

        $validated = $request->validate([
            'body'  => 'nullable|string|max:2000',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:5120',
        ]);

        $bodyText = trim($request->input('body', ''));
        $hasBody  = $bodyText !== '';
        $hasImage = $request->hasFile('image') && $request->file('image')->isValid();

        if (!$hasBody && !$hasImage) {
            return response()->json(['error' => 'Message cannot be empty.'], 422);
        }

        $imagePath = null;
        if ($hasImage) {
            $imagePath = $request->file('image')
                ->store('order-chat-images', 'public');
        }

        $message = OrderMessage::create([
            'baker_order_id' => $order->id,
            'sender_id'      => $user->id,
            'body'           => $hasBody ? $bodyText : null,
            'image_path'     => $imagePath,
        ]);

        OrderMessage::where('baker_order_id', $order->id)
            ->where('sender_id', '!=', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $message->load('sender');
try {
    $recipient = $isCustomer ? $order->baker : $order->cakeRequest->user;
    if ($recipient) {
        $recipient->notify(
            new \App\Notifications\NewMessageNotification($message, $order)
        );
    }
} catch (\Throwable $e) {
    \Log::error('Chat notification failed for order #' . $order->id . ': ' . $e->getMessage());
}

        return response()->json([
            'message' => $this->formatMessage($message),
        ], 201);
    }

    /**
     * Poll for new messages since a given message ID.
     * Called by the chat bubble every 3 seconds.
     *
     * GET /chat/orders/{order}/messages/poll?after={last_id}
     */
    public function poll(Request $request, BakerOrder $order)
    {
        $user = Auth::user();

        $isCustomer = $order->cakeRequest->user_id === $user->id;
        $isBaker    = $order->baker_id === $user->id;
        abort_if(!$isCustomer && !$isBaker, 403);

        $afterId = (int) $request->query('after', 0);

   $messages = OrderMessage::where('baker_order_id', $order->id)
            ->where('id', '>', $afterId)
            ->where('sender_id', '!=', $user->id)
            ->with('sender')
            ->orderBy('id')
            ->get();
        // Mark messages from the other party as read
        if ($messages->isNotEmpty()) {
            OrderMessage::where('baker_order_id', $order->id)
                ->where('sender_id', '!=', $user->id)
                ->whereNull('read_at')
                ->update(['read_at' => now()]);
        }

        return response()->json([
            'messages' => $messages->map(fn($m) => $this->formatMessage($m)),
        ]);
    }

    /**
     * Format a message for the frontend JSON response.
     */
    private function formatMessage(OrderMessage $message): array
    {
        return [
            'id'         => $message->id,
            'sender_id'  => $message->sender_id,
            'body'       => $message->body,
            'image_url'  => $message->image_path
                              ? asset('storage/' . $message->image_path)
                              : null,
            'read_at'    => $message->read_at?->toISOString(),
            'created_at' => $message->created_at->toISOString(),
        ];
    }
}