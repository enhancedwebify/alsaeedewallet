<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    /**
     * Show the user profile page.
     */
    public function index()
    {
        $user = Auth::user();

        return view('user.profile', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone_number' => [ 'string', 'max:20', Rule::unique('users')->ignore($user->id)],
            // Add other fields you want to update 'nullable', in above i removed it to prevent being save nullable
        ]);
        // dd($request->all());

        $user->update([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            // Update other fields here
        ]);

        return back()->with('success', 'تم تحديث ملفك الشخصي بنجاح!');
    }
}
