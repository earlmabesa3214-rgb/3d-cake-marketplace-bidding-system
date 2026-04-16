<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Baker;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class BakerRegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.baker-register');
    }

    public function store(Request $request)
    {
        $sellerType = $request->input('seller_type', 'registered');

        $rules = [
            'first_name'       => ['required', 'string', 'max:100'],
            'last_name'        => ['required', 'string', 'max:100'],
            'email'            => ['required', 'email', 'unique:users,email', 'unique:bakers,email'],
            'phone'            => ['required', 'string', 'max:20'],
            'password'         => ['required', 'string', 'min:8', 'confirmed'],
            'shop_name'        => ['required', 'string', 'max:150'],
            'experience_years' => ['required', 'string'],
            'min_order_price'  => ['nullable', 'numeric', 'min:0'],
            'social_media'     => ['nullable', 'url', 'max:300'],
            'bio'              => ['nullable', 'string', 'max:1000'],
            'specialties'      => ['nullable', 'array'],
            'portfolio.*'      => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:5120'],
            'latitude'         => ['nullable', 'numeric'],
            'longitude'        => ['nullable', 'numeric'],
            'full_address'     => ['nullable', 'string', 'max:500'],
            'seller_type'      => ['required', 'in:registered,homebased'],
        ];

        if ($sellerType === 'registered') {
            $rules['dti_sec_number']  = ['required', 'string', 'max:100'];
            $rules['business_permit'] = ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:10240'];
            $rules['dti_certificate'] = ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:10240'];
            $rules['sanitary_permit'] = ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:10240'];
            $rules['bir_certificate'] = ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:10240'];
        } else {
            $rules['gov_id_type']      = ['required', 'string'];
            $rules['gov_id_front']     = ['required', 'file', 'mimes:jpg,jpeg,png', 'max:5120'];
            $rules['gov_id_back']      = ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:5120'];
            $rules['id_selfie']        = ['required', 'file', 'mimes:jpg,jpeg,png', 'max:5120'];
            $rules['food_safety_cert'] = ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'];
        }

        $validated = $request->validate($rules);

        // 1. Create the User first
        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name'  => $validated['last_name'],
            'email'      => $validated['email'],
            'password'   => Hash::make($validated['password']),
            'role'       => 'baker',
        ]);

        // 2. Log the user in immediately
        Auth::login($user);

        // 3. Handle portfolio uploads
        $portfolioPaths = [];
        if ($request->hasFile('portfolio')) {
            foreach ($request->file('portfolio') as $file) {
                $portfolioPaths[] = $file->store('baker_docs/portfolio', 'public');
            }
        }

        // 4. Build baker data with user_id
        $data = [
            'user_id'          => $user->id,
            'name'             => $validated['first_name'] . ' ' . $validated['last_name'],
            'email'            => $validated['email'],
            'phone'            => $validated['phone'],
            'password'         => Hash::make($validated['password']),
            'shop_name'        => $validated['shop_name'],
            'experience_years' => $validated['experience_years'],
            'min_order_price'  => $validated['min_order_price'] ?? null,
            'social_media'     => $validated['social_media'] ?? null,
            'bio'              => $validated['bio'] ?? null,
            'specialties'      => json_encode($validated['specialties'] ?? []),
            'seller_type'      => $sellerType,
            'latitude'         => $validated['latitude'] ?? null,
            'longitude'        => $validated['longitude'] ?? null,
            'full_address'     => $validated['full_address'] ?? null,
            'address'          => $validated['full_address'] ?? null,
            'dti_sec_number'   => $request->input('dti_sec_number'),
            'gov_id_type'      => $request->input('gov_id_type'),
            'status'           => 'pending',
            'portfolio'        => json_encode($portfolioPaths),
        ];

        $fileFields = [
            'business_permit'  => 'baker_docs/permits',
            'dti_certificate'  => 'baker_docs/permits',
            'sanitary_permit'  => 'baker_docs/permits',
            'bir_certificate'  => 'baker_docs/permits',
            'gov_id_front'     => 'baker_docs/gov_id',
            'gov_id_back'      => 'baker_docs/gov_id',
            'id_selfie'        => 'baker_docs/selfies',
            'food_safety_cert' => 'baker_docs/food_cert',
        ];

        foreach ($fileFields as $field => $folder) {
            if ($request->hasFile($field)) {
                $data[$field] = $request->file($field)->store($folder, 'public');
            }
        }

        Baker::create($data);

        return redirect()->route('baker.waiting')
            ->with('pending_approval', 'Your baker application has been submitted! An admin will review it within 1–2 business days.');
    }
}