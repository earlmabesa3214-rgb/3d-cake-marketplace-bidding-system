<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\IngredientController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\BakerController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\SalesReportController;
use App\Http\Controllers\Admin\SystemController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerDashboardController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\BakerRegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\CakeBuilderController;
use App\Http\Controllers\CakeRequestController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderMessageController;
use App\Http\Controllers\Baker\BakerDashboardController;
use App\Http\Controllers\Baker\BakerRequestController;
use App\Http\Controllers\Baker\BidController;
use App\Http\Controllers\Baker\BakerOrderController;
use App\Http\Controllers\Baker\BakerEarningsController;
use App\Http\Controllers\Baker\BakerProfileController;
use App\Http\Controllers\Baker\BakerNotificationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Baker\BakerPaymentMethodController;
use App\Http\Controllers\Customer\CustomerPaymentController;
use App\Http\Controllers\Customer\ReviewController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\BakerCompleteProfileController;
use App\Http\Controllers\CakeGalleryController;

// ─── ROOT ─────────────────────────────────────────────────────────────────────
Route::get('/', fn() => redirect()->route('login'));

// ─── GUEST-ONLY ROUTES ────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/register',        [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register',       [RegisterController::class, 'register']);
    Route::get('/login',           [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login',          [LoginController::class, 'login']);
    Route::get('/baker/register',  [BakerRegisterController::class, 'showRegistrationForm'])->name('baker.register');
    Route::post('/baker/register', [BakerRegisterController::class, 'store'])->name('baker.register.submit');


    Route::get('/auth/google',          [GoogleController::class, 'redirect'])->name('auth.google');
    Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('auth.google.callback');
});

// ─── PUBLIC: Smart email provider check ───────────────────────────────────────
Route::post('/check-email-provider', [LoginController::class, 'checkEmailProvider'])
    ->name('check.email.provider');

// ─── LOGOUT ───────────────────────────────────────────────────────────────────
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Baker: fill in shop details after Google OAuth (no auth — new Google users aren't in DB yet)
Route::get('/baker/complete-profile',  [BakerCompleteProfileController::class, 'show'])
    ->name('baker.complete-profile');
Route::post('/baker/complete-profile', [BakerCompleteProfileController::class, 'store'])
    ->name('baker.complete-profile.store');
Route::get('/baker/complete-profile/cancel', function () {
    if (auth()->check()) {
        auth()->logout();
    }
    session()->forget('google_pending');
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('login')
        ->with('info', 'You can complete your baker registration anytime.');
})->name('baker.complete-profile.cancel');

Route::middleware('auth')->group(function () {

    // Pending bakers wait here until approved
    Route::get('/baker/waiting', function () {
        $user  = auth()->user();
        $baker = $user->baker;

        if ($baker && $baker->status === 'approved') {
            return redirect()->route('baker.dashboard');
        }

        return view('baker.waiting');
    })->name('baker.waiting');

// Customer: fill in phone after Google OAuth
    // Note: intentionally no auth middleware — pending Google customers aren't logged in yet
    Route::get('/customer/complete-profile',  [App\Http\Controllers\Auth\CustomerCompleteProfileController::class, 'show'])
        ->name('customer.complete-profile')->withoutMiddleware('auth');
    Route::post('/customer/complete-profile', [App\Http\Controllers\Auth\CustomerCompleteProfileController::class, 'store'])
        ->name('customer.complete-profile.store')->withoutMiddleware('auth');
});

// ─── PAYMONGO WEBHOOK (no CSRF) ───────────────────────────────────────────────
Route::post('/webhooks/paymongo', [PaymentController::class, 'webhook'])
    ->name('webhooks.paymongo')
    ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

Route::middleware('auth')->get('/baker-info/{userId}', function ($userId) {
    // baker_id on bids could be user_id OR baker.id — try both
    $baker = \App\Models\Baker::where('user_id', $userId)->first();
    if (!$baker) {
        $baker = \App\Models\Baker::where('id', $userId)->first();
    }
    $reviews = collect();

    try {
        $reviews = \App\Models\BakerReview::where('baker_user_id', $userId)
            ->with('customer:id,first_name,last_name')
            ->latest()->take(3)->get()
            ->map(fn($r) => [
                'name'    => $r->customer
                    ? $r->customer->first_name . ' ' . substr($r->customer->last_name, 0, 1) . '.'
                    : 'Customer',
                'rating'  => $r->rating  ?? 5,
                'comment' => $r->comment ?? '',
                'date'    => $r->created_at->format('M d, Y'),
            ]);
    } catch (\Exception $e) {}

// ── AFTER: look up the baker's user address ──
$resolvedAddress = null;

// 1. Try the baker's default address from the addresses table
if ($baker?->user_id) {
    $defaultAddress = \App\Models\Address::where('user_id', $baker->user_id)
        ->where('is_default', true)
        ->first();

    if (!$defaultAddress) {
        // Fall back to any address they have
        $defaultAddress = \App\Models\Address::where('user_id', $baker->user_id)
            ->latest()
            ->first();
    }

    if ($defaultAddress) {
        $resolvedAddress = $defaultAddress->full_address;
        // Also grab coordinates from the address if baker coords are missing
        if (!$baker->latitude && $defaultAddress->latitude) {
            $baker->latitude  = $defaultAddress->latitude;
            $baker->longitude = $defaultAddress->longitude;
        }
    }
}

// 2. Fall back to reverse-geocoding baker's coordinates
if (!$resolvedAddress && $baker?->latitude && $baker?->longitude) {
    try {
        $geo = \Illuminate\Support\Facades\Http::timeout(3)
            ->withHeaders(['User-Agent' => 'BakeSphere/1.0'])
            ->get('https://nominatim.openstreetmap.org/reverse', [
                'format' => 'jsonv2',
                'lat'    => $baker->latitude,
                'lon'    => $baker->longitude,
            ]);
        if ($geo->ok()) {
            $resolvedAddress = $geo->json('display_name');
        }
    } catch (\Exception $e) {}
}

    // If still empty but we have coordinates, reverse-geocode on the server
    if (!$resolvedAddress && $baker?->latitude && $baker?->longitude) {
        try {
            $geo = \Illuminate\Support\Facades\Http::timeout(3)
                ->withHeaders(['User-Agent' => 'BakeSphere/1.0'])
                ->get('https://nominatim.openstreetmap.org/reverse', [
                    'format' => 'jsonv2',
                    'lat'    => $baker->latitude,
                    'lon'    => $baker->longitude,
                ]);
            if ($geo->ok()) {
                $resolvedAddress = $geo->json('display_name');
                // Save it back so we don't need to geocode again next time
                $baker->update(['address' => $resolvedAddress]);
            }
        } catch (\Exception $e) {}
    }
$liveCount  = \App\Models\BakerReview::where('baker_user_id', $userId)->count();
$liveAvg    = \App\Models\BakerReview::where('baker_user_id', $userId)->avg('rating');

return response()->json([
    'address'       => $resolvedAddress,
    'rating'        => $liveCount > 0 ? round((float) $liveAvg, 1) : null,
    'total_reviews' => $liveCount,
    'latitude'      => $baker?->latitude  ?? null,
    'longitude'     => $baker?->longitude ?? null,
    'reviews'       => $reviews,
]);
});

Route::middleware('auth')->get('/baker-reviews/{userId}', function ($userId) {
    $reviews = \App\Models\BakerReview::where('baker_user_id', $userId)
        ->with('customer:id,first_name,last_name')
        ->latest()->get()
        ->map(fn($r) => [
            'name'    => $r->customer
                ? $r->customer->first_name . ' ' . substr($r->customer->last_name, 0, 1) . '.'
                : 'Customer',
            'rating'  => $r->rating  ?? 5,
            'comment' => $r->comment ?? '',
            'date'    => $r->created_at->format('M d, Y'),
        ]);

$liveTotal = \App\Models\BakerReview::where('baker_user_id', $userId)->count();
    $liveAvg   = \App\Models\BakerReview::where('baker_user_id', $userId)->avg('rating');

    return response()->json([
        'reviews' => $reviews,
        'total'   => $liveTotal,
        'avg'     => $liveTotal > 0 ? round((float) $liveAvg, 1) : 0,
    ]);
});
Route::middleware('auth')->get('/baker-public-profile/{bakerId}',
    [\App\Http\Controllers\ProfileController::class, 'bakerPublicProfile'])
    ->name('baker.public-profile');
// ─── CUSTOMER ROUTES ──────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:customer'])->prefix('customer')->name('customer.')->group(function () {

    Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile',      [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile',      [ProfileController::class, 'update'])->name('profile.update');

    Route::post('/addresses',                        [AddressController::class, 'store'])->name('addresses.store');
    Route::put('/addresses/{address}',               [AddressController::class, 'update'])->name('addresses.update');
    Route::delete('/addresses/{address}',            [AddressController::class, 'destroy'])->name('addresses.destroy');
    Route::patch('/addresses/{address}/set-default', [AddressController::class, 'setDefault'])->name('addresses.setDefault');

    Route::get('/cake-builder',                   [CakeBuilderController::class, 'index'])->name('cake-builder.index');
    Route::post('/cake-builder/price',            [CakeBuilderController::class, 'calculatePrice'])->name('cake-builder.price');
    Route::post('/cake-builder/save-draft',       [CakeBuilderController::class, 'saveDraft'])->name('cake-builder.saveDraft');
    Route::get('/cake-builder/load-draft',        [CakeBuilderController::class, 'loadDraft'])->name('cake-builder.loadDraft');
    Route::post('/cake-builder/save-and-proceed', [CakeBuilderController::class, 'saveAndProceed'])->name('cake-builder.saveAndProceed');
Route::get('/cake-gallery',        [CakeGalleryController::class, 'index'])->name('cake-gallery.index');
    Route::get('/cake-builder/drafts', [CakeBuilderController::class, 'drafts'])->name('cake-builder.drafts');
    Route::delete('/cake-builder/draft', [CakeBuilderController::class, 'discardDraft'])->name('cake-builder.discardDraft');

    Route::resource('cake-requests', CakeRequestController::class)->except(['edit', 'update']);
    Route::post('/cake-requests/{cakeRequest}/accept-bid/{bid}',
        [CakeRequestController::class, 'acceptBid'])->name('cake-requests.accept-bid');
// ── Wallet ──
    Route::get('/wallet',              [\App\Http\Controllers\Customer\WalletController::class, 'index'])->name('wallet.index');
    Route::post('/wallet/cash-in',     [\App\Http\Controllers\Customer\WalletController::class, 'cashIn'])->name('wallet.cash-in');

   Route::post('/orders/{order}/pay-downpayment',   [\App\Http\Controllers\Customer\CustomerOrderController::class, 'payDownpayment'])->name('orders.pay-downpayment');
Route::post('/orders/{order}/confirm-cake-pay',  [\App\Http\Controllers\Customer\CustomerOrderController::class, 'confirmCakeAndPay'])->name('orders.confirm-cake-pay');
Route::post('/orders/{order}/confirm-received',  [\App\Http\Controllers\Customer\CustomerOrderController::class, 'confirmReceived'])->name('orders.confirm-received');
Route::post('/orders/{order}/confirm-pickup',    [\App\Http\Controllers\Customer\CustomerOrderController::class, 'confirmPickup'])->name('orders.confirm-pickup');
    Route::get('/cake-requests/{cakeRequest}/payment',             [CustomerPaymentController::class, 'show'])->name('payment.show');
    Route::post('/cake-requests/{cakeRequest}/payment/proof',      [CustomerPaymentController::class, 'submitProof'])->name('payment.submit-proof');
    Route::post('/cake-requests/{cakeRequest}/payment/reupload',   [CustomerPaymentController::class, 'reupload'])->name('payment.reupload');
    Route::post('/cake-requests/{cakeRequest}/payment/refresh-qr', [CustomerPaymentController::class, 'refreshQr'])->name('payment.refresh-qr');
    Route::post('/cake-requests/{cakeRequest}/payment',            [PaymentController::class, 'initiate'])->name('payment.initiate');
    Route::get('/cake-requests/{cakeRequest}/payment/success',     [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/cake-requests/{cakeRequest}/payment/failed',      [PaymentController::class, 'failed'])->name('payment.failed');

    Route::post('/orders/{order}/confirm-delivery', [ReviewController::class, 'confirmDelivery'])->name('orders.confirm-delivery');
    Route::post('/orders/{order}/review',           [ReviewController::class, 'store'])->name('orders.review');

    Route::get('/notifications/unread-count', fn() => response()->json(['count' => auth()->user()->unreadNotifications->count()]))->name('notifications.unread-count');
    Route::get('/notifications',            [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/read-all',  [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::delete('/notifications/{id}',    [NotificationController::class, 'destroy'])->name('notifications.destroy');

Route::get('/rush-baker-preview', function (\Illuminate\Http\Request $request) {
    $lat = (float) $request->query('lat');
    $lng = (float) $request->query('lng');

    $baker = \App\Models\Baker::where('accepts_rush_orders', true)
        ->where('is_available', true)
        ->where('status', 'approved')
        ->whereNotNull('latitude')
        ->whereNotNull('longitude')
        ->get()
        ->sortBy(function ($baker) use ($lat, $lng) {
            $R    = 6371;
            $dLat = deg2rad($baker->latitude - $lat);
            $dLng = deg2rad($baker->longitude - $lng);
            $a    = sin($dLat/2)**2 + cos(deg2rad($lat)) * cos(deg2rad($baker->latitude)) * sin($dLng/2)**2;
            return $R * 2 * atan2(sqrt($a), sqrt(1-$a));
        })
        ->first();

    if (!$baker) {
        return response()->json(['error' => 'No rush baker available']);
    }

    $user = \App\Models\User::find($baker->user_id);

    return response()->json([
        'name'          => $user ? $user->first_name . ' ' . $user->last_name : 'Baker',
        'address'       => $baker->address,
        'latitude'      => $baker->latitude,
        'longitude'     => $baker->longitude,
        'rating'        => $baker->rating,
        'total_reviews' => $baker->total_reviews ?? 0,
        'rush_fee'      => $baker->rush_fee ?? 0,
    ]);
})->name('rush-baker-preview');

   Route::post('/cake-requests/{cakeRequest}/update-fulfillment', function (\Illuminate\Http\Request $request, \App\Models\CakeRequest $cakeRequest) {
        abort_if($cakeRequest->user_id !== auth()->id(), 403);
        $cakeRequest->update([
            'fulfillment_type' => $request->fulfillment_type === 'pickup' ? 'pickup' : 'delivery'
        ]);
        return response()->json(['ok' => true]);
    })->name('cake-requests.update-fulfillment');

    // Real-time state polling
    Route::get('/cake-requests/{cakeRequest}/state-poll',
        [\App\Http\Controllers\OrderStatePollController::class, 'customerPoll']
    )->name('cake-requests.state-poll');

}); // ← closes the customer group
// ─── BAKER ROUTES ─────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:baker'])->prefix('baker')->name('baker.')->group(function () {

    Route::get('/dashboard', [BakerDashboardController::class, 'index'])->name('dashboard');

    Route::get('/requests',      [BakerRequestController::class, 'index'])->name('requests.index');
    Route::get('/requests/{id}', [BakerRequestController::class, 'show'])->name('requests.show');

    Route::get('/bids',          [BidController::class, 'index'])->name('bids.index');
    Route::post('/bids',         [BidController::class, 'store'])->name('bids.store')->middleware('baker.profile.complete');
    Route::delete('/bids/{bid}', [BidController::class, 'destroy'])->name('bids.destroy');

    // ── Rush order: baker accepts instantly (no bid, direct assignment) ──
    Route::post('/rush-orders/{cakeRequest}/accept',
        [\App\Http\Controllers\Baker\RushOrderController::class, 'accept'])
        ->name('rush-orders.accept');

    Route::get('/orders',                  [BakerOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}',          [BakerOrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/advance', [BakerOrderController::class, 'advance'])->name('orders.advance');

    Route::post('/orders/{order}/confirm-payment',       [BakerOrderController::class, 'confirmPayment'])->name('orders.confirm-payment');
    Route::post('/orders/{order}/confirm-final-payment', [BakerOrderController::class, 'confirmFinalPayment'])->name('orders.confirm-final-payment');
    Route::post('/orders/{order}/reject-payment',        [BakerOrderController::class, 'rejectPayment'])->name('orders.reject-payment');

  Route::get('/earnings', [BakerEarningsController::class, 'index'])->name('earnings.index');

  Route::get('/wallet',         [\App\Http\Controllers\Baker\BakerWalletController::class, 'index'])->name('wallet.index');
    Route::post('/wallet/withdraw', [\App\Http\Controllers\Baker\BakerWalletController::class, 'requestWithdrawal'])->name('wallet.withdraw');

    Route::get('/profile',       [BakerProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit',  [BakerProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile',       [BakerProfileController::class, 'update'])->name('profile.update');
Route::post('/availability', [BakerProfileController::class, 'toggleAvailability'])->name('availability.toggle');
    Route::post('/toggle-rush',  [BakerProfileController::class, 'toggleRush'])->name('toggle-rush');
    Route::get('/payment-methods',                           [BakerPaymentMethodController::class, 'index'])->name('payment-methods.index');
    Route::post('/payment-methods',                          [BakerPaymentMethodController::class, 'store'])->name('payment-methods.store');
    Route::put('/payment-methods/{paymentMethod}',           [BakerPaymentMethodController::class, 'update'])->name('payment-methods.update');
    Route::delete('/payment-methods/{paymentMethod}',        [BakerPaymentMethodController::class, 'destroy'])->name('payment-methods.destroy');
    Route::post('/payment-methods/confirm-cash/{paymentId}', [BakerPaymentMethodController::class, 'confirmCash'])->name('payment-methods.confirm-cash');

    Route::get('/notifications/unread-count', fn() => response()->json(['count' => auth()->user()->unreadNotifications->count()]))->name('notifications.unread-count');
    Route::get('/notifications',            [BakerNotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/read-all',  [BakerNotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
    Route::post('/notifications/{id}/read', [BakerNotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::delete('/notifications/{id}',    [BakerNotificationController::class, 'destroy'])->name('notifications.destroy');

    // Real-time state polling
    Route::get('/orders/{order}/state-poll',
        [\App\Http\Controllers\OrderStatePollController::class, 'bakerPoll']
    )->name('orders.state-poll');
});

// ─── SHARED CHAT ROUTES ───────────────────────────────────────────────────────
Route::middleware('auth')->prefix('chat')->group(function () {
    Route::post('/orders/{order}/messages',     [OrderMessageController::class, 'store'])->name('order.messages.store');
    Route::get('/orders/{order}/messages/poll', [OrderMessageController::class, 'poll'])->name('order.messages.poll');
});

// ─── SHARED REPORT ROUTES ─────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
 Route::get('/debug-order/{bakerOrder}', function(\App\Models\BakerOrder $bakerOrder) {
        return response()->json([
            'auth_id'            => auth()->id(),
            'baker_id_raw'       => $bakerOrder->baker_id,
            'baker_user_id'      => optional($bakerOrder->baker)->user_id,
            'customer_user_id'   => optional($bakerOrder->cakeRequest)->user_id,
            'baker_relation'     => $bakerOrder->baker?->toArray(),
        ]);
    })->middleware('auth');

    Route::get('/report/order/{bakerOrder}',  [\App\Http\Controllers\ReportController::class, 'create'])->name('report.create');
    Route::post('/report/order/{bakerOrder}', [\App\Http\Controllers\ReportController::class, 'store'])->name('report.store');
    Route::get('/reports/my',                 [\App\Http\Controllers\ReportController::class, 'myReports'])->name('report.my');
});

// ─── ADMIN ROUTES ─────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('ingredients', IngredientController::class);
    Route::resource('orders',      OrderController::class);
    Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status');
    Route::resource('products',  ProductController::class);
    Route::resource('bakers',    BakerController::class);
    Route::patch('bakers/{baker}/approve', [BakerController::class, 'approve'])->name('bakers.approve');
    Route::patch('bakers/{baker}/reject',  [BakerController::class, 'reject'])->name('bakers.reject');
    Route::resource('customers', CustomerController::class);

    Route::get('reports',   [SalesReportController::class, 'index'])->name('reports.index');
    Route::get('system',    [SystemController::class,      'index'])->name('system.index');
    Route::get('settings',  [SettingController::class,     'index'])->name('settings.index');
    Route::post('settings', [SettingController::class,     'update'])->name('settings.update');

   Route::get('/wallet',                                         [\App\Http\Controllers\Admin\WalletAdminController::class, 'index'])->name('admin.wallet.index');
    Route::post('/wallet/cashin/{cashIn}/approve',                [\App\Http\Controllers\Admin\WalletAdminController::class, 'approveCashIn'])->name('admin.wallet.cashin.approve');
    Route::post('/wallet/cashin/{cashIn}/reject',                 [\App\Http\Controllers\Admin\WalletAdminController::class, 'rejectCashIn'])->name('admin.wallet.cashin.reject');
    Route::post('/wallet/withdrawals/{withdrawal}/approve',       [\App\Http\Controllers\Admin\WalletAdminController::class, 'approveWithdrawal'])->name('admin.wallet.withdrawal.approve');
    Route::post('/wallet/withdrawals/{withdrawal}/reject',        [\App\Http\Controllers\Admin\WalletAdminController::class, 'rejectWithdrawal'])->name('admin.wallet.withdrawal.reject');
    Route::get('/admin/reports',            [AdminReportController::class, 'index'])->name('admin.reports.index');
    Route::get('/admin/reports/{report}',   [AdminReportController::class, 'show'])->name('admin.reports.show');
    Route::patch('/admin/reports/{report}', [AdminReportController::class, 'update'])->name('admin.reports.update');

Route::get('/admin/transactions',              [TransactionController::class, 'index'])->name('admin.transactions.index');
    Route::get('/admin/transactions/{bakerOrder}', [TransactionController::class, 'show'])->name('admin.transactions.show');

    Route::get('/admin/escrow',                                    [\App\Http\Controllers\Admin\EscrowController::class, 'index'])->name('admin.escrow.index');
    Route::post('/admin/escrow/payments/{payment}/confirm',        [\App\Http\Controllers\Admin\EscrowController::class, 'confirmPayment'])->name('admin.escrow.confirm');
    Route::post('/admin/escrow/payments/{payment}/reject',         [\App\Http\Controllers\Admin\EscrowController::class, 'rejectPayment'])->name('admin.escrow.reject');
    Route::post('/admin/escrow/withdrawals/{withdrawal}/approve',  [\App\Http\Controllers\Admin\EscrowController::class, 'approveWithdrawal'])->name('admin.escrow.withdrawal.approve');
    Route::post('/admin/escrow/withdrawals/{withdrawal}/reject',   [\App\Http\Controllers\Admin\EscrowController::class, 'rejectWithdrawal'])->name('admin.escrow.withdrawal.reject');
    Route::post('/admin/escrow/accounts/{account}',                [\App\Http\Controllers\Admin\EscrowController::class, 'updatePlatformAccount'])->name('admin.escrow.account.update');
});