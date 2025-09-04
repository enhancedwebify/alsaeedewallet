<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contribution;
use App\Models\User;
use App\Models\ContributionApprovals;
use App\Models\LoanTier;
use Illuminate\Support\Facades\Auth;


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
     * Store a new tier change request.
     */
    public function storeTierRequest(Request $request)
    {
        // $user = Auth::user();
        $user = User::where('id_number', id_number())->with('contributions')->first();
        // Check for existing pending requests of this type to prevent duplicates
        $hasPendingRequest = ContributionApprovals::where('user_id', $user->id)
                                                 ->where('type', 'tier_change_request')
                                                 ->where('status', 'pending')
                                                 ->exists();

        if ($hasPendingRequest) {
            return redirect()->back()->with('error', 'لديك طلب تغيير شريحة مساهمة معلق بالفعل.');
        }

        // Validate the incoming request data
        $request->validate([
            'loan_tier_id' => 'required|exists:loan_tiers,id',
        ]);

        // Find the selected new tier
        $newTier = LoanTier::findOrFail($request->input('loan_tier_id'));

        // Get the user's current monthly contribution amount.
        // We assume the latest monthly subscription contribution reflects the current amount.
        $currentMonthlyContribution = $user->contributions()->where('type', 'additional_contribution')->latest('transaction_date')->value('amount');

        // Calculate the total monthly contribution after the change
        $totalMonthlyContribution = $currentMonthlyContribution + $newTier->monthly_installment;

        // Check against the 10,000 SAR limit
        if ($totalMonthlyContribution > 10000) {
            return redirect()->back()->with('error', 'إجمالي المساهمات الشهرية يتجاوز الحد الأقصى المسموح به (10,000 ريال).');
        }

        // Create the new contribution approval record for the tier change
        ContributionApprovals::create([
            'user_id' => $user->id,
            'loan_tier_id' => $request->input('loan_tier_id'),
            'status' => 'pending',
            'type' => 'tier_change_request',
            'notes' => 'طلب تغيير شريحة المساهمة إلى شريحة رقم ' . $newTier->tier_number,
        ]);

        return redirect()->back()->with('success', 'تم إرسال طلب تغيير الشريحة بنجاح. سيتم مراجعته من قبل الإدارة.');
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
