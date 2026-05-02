<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Baker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BakerCompleteProfileController extends Controller
{
public function show()
    {
        $user = Auth::user();

        if (!$user) {
            $pending = session('google_pending');
            if (!$pending || $pending['role'] !== 'baker') {
                return redirect()->route('login');
            }
            // Unsaved user object just for the view
            $user  = new \App\Models\User($pending);
            $baker = null;
            return view('auth.baker-complete-profile', compact('user', 'baker'));
        }

        $baker = $user->baker;

        if ($baker && !empty($baker->shop_name)) {
            return redirect()->route('baker.dashboard');
        }

        return view('auth.baker-complete-profile', compact('user', 'baker'));
    }
  public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            $pending = session('google_pending');
            if (!$pending || $pending['role'] !== 'baker') {
                return redirect()->route('login');
            }

            $user = \App\Models\User::create([
                'first_name'    => $pending['first_name'],
                'last_name'     => $pending['last_name'],
                'email'         => $pending['email'],
                'password'      => bcrypt(\Illuminate\Support\Str::random(24)),
                'provider'      => 'google',
                'role'          => 'baker',
                'profile_photo' => $pending['profile_photo'],
                'is_verified'   => true,
            ]);

            Baker::create([
                'user_id' => $user->id,
                'name'    => $user->first_name . ' ' . $user->last_name,
                'email'   => $user->email,
                'status'  => 'pending',
            ]);

            session()->forget('google_pending');
            Auth::login($user);
        }

        $baker = $user->baker;

        $request->validate([
         'phone'     => 'required|string|size:11',
'birthdate' => 'required|date|before:' . now()->subYears(18)->toDateString(),
'password'  => 'required|string|min:8|confirmed',

            'shop_name'        => 'required|string|max:255',
            'experience_years' => 'required|string',
   
            'seller_type'      => 'required|in:registered,homebased',
            'full_address'     => 'nullable|string|max:500',
            'latitude'         => 'nullable|numeric',
            'longitude'        => 'nullable|numeric',
            'bio'              => 'nullable|string|max:1000',
            'social_media'     => 'nullable|url|max:255',
            'specialties'      => 'nullable|array',
            'portfolio.*'      => 'nullable|image|max:5120',

            // Registered business docs
            'dti_sec_number'   => 'required_if:seller_type,registered|nullable|string',
            'business_permit'  => 'required_if:seller_type,registered|nullable|file|max:5120',
            'dti_certificate'  => 'required_if:seller_type,registered|nullable|file|max:5120',
            'sanitary_permit'  => 'required_if:seller_type,registered|nullable|file|max:5120',
            'bir_certificate'  => 'nullable|file|max:5120',

            // Home-based docs
            'gov_id_type'      => 'required_if:seller_type,homebased|nullable|string',
            'gov_id_front'     => 'required_if:seller_type,homebased|nullable|image|max:5120',
            'gov_id_back'      => 'nullable|image|max:5120',
            'id_selfie'        => 'required_if:seller_type,homebased|nullable|image|max:5120',
            'food_safety_cert' => 'nullable|file|max:5120',
        ]);

 $user->update([
    'phone'     => $request->phone,
    'birthdate' => $request->birthdate,
    'password'  => bcrypt($request->password),
]);

        // Helper to store uploaded file
        $store = fn($file, $path) => $file ? $file->store($path, 'public') : null;

        // Build the update payload
        $data = [
            'shop_name'        => $request->shop_name,
            'experience_years' => $request->experience_years,
           
            'seller_type'      => $request->seller_type,
            'bio'              => $request->bio,
            'social_media'     => $request->social_media,
            'specialties'      => $request->specialties ?? [],
            'full_address'     => $request->full_address,
            'latitude'         => $request->latitude,
            'longitude'        => $request->longitude,
            'address'          => $request->full_address,
            'status'           => 'pending',
        ];

        if ($request->seller_type === 'registered') {
            $data['dti_sec_number'] = $request->dti_sec_number;
            if ($request->hasFile('business_permit'))  $data['business_permit']  = $store($request->file('business_permit'),  'baker-docs');
            if ($request->hasFile('dti_certificate'))  $data['dti_certificate']  = $store($request->file('dti_certificate'),  'baker-docs');
            if ($request->hasFile('sanitary_permit'))  $data['sanitary_permit']  = $store($request->file('sanitary_permit'),  'baker-docs');
            if ($request->hasFile('bir_certificate'))  $data['bir_certificate']  = $store($request->file('bir_certificate'),  'baker-docs');
        } else {
            $data['gov_id_type'] = $request->gov_id_type;
            if ($request->hasFile('gov_id_front'))    $data['gov_id_front']    = $store($request->file('gov_id_front'),    'baker-ids');
            if ($request->hasFile('gov_id_back'))     $data['gov_id_back']     = $store($request->file('gov_id_back'),     'baker-ids');
            if ($request->hasFile('id_selfie'))       $data['id_selfie']       = $store($request->file('id_selfie'),       'baker-ids');
            if ($request->hasFile('food_safety_cert'))$data['food_safety_cert']= $store($request->file('food_safety_cert'),'baker-docs');
        }

        // Portfolio photos
        if ($request->hasFile('portfolio')) {
            $paths = [];
            foreach ($request->file('portfolio') as $photo) {
                $paths[] = $photo->store('baker-portfolio', 'public');
            }
            $data['portfolio'] = json_encode($paths);
        }

        $baker->update($data);

        return redirect()->route('login')
            ->with('pending_approval', 'Your baker profile is complete! Our admin team will review and approve your account within 1–2 business days.');
    }
}