<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Add this line

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $users = User::orderBy('full_name')->get();

        return view('admin.users.index', compact('users'));
    }
      /**
     * Display the specified user's profile.
     */
    public function show(User $user)
    {
        // Eager load the user's loans and contributions
        $user->load(['loans.repayments', 'contributions']);

        return view('admin.users.show', compact('user'));
    }
    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        // Validation rules for the new user
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'is_admin' => 'nullable|boolean',
        ]);

        // Create the new user record
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => $request->has('is_admin'), // Check if the checkbox was checked
        ]);

        // Redirect back to the user list with a success message
        return redirect()->route('admin.users.index')
                         ->with('success', 'تمت إضافة عضو جديد بنجاح.');
    }
 /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        // Validation rules for the user data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            // You can add more validation rules here
        ]);

        // Update the user's information
        $user->full_name = $request->input('name');
        $user->email = $request->input('email');
        // You can add more fields to update here
        $user->save();

        // Redirect back to the user's profile with a success message
        return redirect()->route('admin.users.show', $user->id)
                         ->with('success', 'تم تحديث معلومات العضو بنجاح.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete(); // This performs a soft delete

        return redirect()->route('admin.users.index')
                         ->with('success', 'تم حذف العضو بنجاح.');
    }
}
