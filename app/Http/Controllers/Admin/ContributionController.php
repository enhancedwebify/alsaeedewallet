<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contribution;
use App\Models\User;

class ContributionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Fetch all users to populate the user dropdown
        $users = User::all();
        return view('admin.contributions.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
          // Validate the incoming request data
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0.01',
            'transaction_date' => 'required|date',
            'type' => 'required|string|in:monthly_subscription,joining_fee,additional_contribution',
        ]);

        // Create the new contribution record
        Contribution::create([
            'user_id' => $request->input('user_id'),
            'amount' => $request->input('amount'),
            'transaction_date' => $request->input('transaction_date'),
            'type' => $request->input('type'),
        ]);

        return redirect()->route('superuser.dashboard')->with('success', 'تم إضافة المساهمة بنجاح.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
