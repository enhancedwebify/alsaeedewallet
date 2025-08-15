<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use App\Models\LoanTier;

class RegistrationController extends Controller
{
    /**
     * Show the registration form.
     */
    public function create()
    {
        // Fetch all loan tiers from the database
        $loan_tiers = LoanTier::get();

        // Pass the tiers to your view
        return view('register', compact('loan_tiers'));
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request)
    {
        // 1. Validation
        $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'id_number' => ['required', 'string', 'unique:users,id_number'],
            'phone_number' => ['required', 'string', 'max:20'],
            'email' => ['required', 'string', 'email', 'max:191', 'unique:users'],
            // 'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'password' => ['required', 'confirmed'],
            'id_photo' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'terms_correct' => ['required', 'accepted'],
            'terms_agreed' => ['required', 'accepted'],
        ]);

        // 2. File Upload
        $path = $request->file('id_photo')->store('id_photos', 'public');

        // 3. Save to Database
        $user = User::create([
            'full_name' => $request->full_name,
            'id_number' => $request->id_number,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'bank_name' => $request->bank_name,
            'bank_account_number' => $request->bank_account_number,
            'loan_tier_id' => $request->loan_tier_id,
            'iban' => $request->iban,
            'id_photo_path' => $path,
            // You can add other fields from the dbdiagram here if you've added them to the form
        ]);

        // 4. (Optional) Log the user in and redirect
        // Auth::login($user);

        return redirect()->route('user.login')->with('success', 'تم التسجيل بنجاح! يرجى انتظار موافقة المسؤول.');
    }
}
