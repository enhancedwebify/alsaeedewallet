<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContributionApprovals;
use App\Models\Contribution;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\LoanTier;
use App\Models\Loan;

class UserDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $requests = User::where('id_number',id_number())->with('loanTier')->first();
        // return view('user.dashboard',compact('requests'));
        // Fetch the user's data along with the loan tier relationship
        $user = User::where('id_number', id_number())->with('approvals.loanTier')->first();
         // Fetch all loan tiers from the database
        $loan_tiers = LoanTier::get();

        // $ca = ContributionApprovals::where('user_id',$user->id)->get();
        // dump($user);
        // 1. Calculate Total Contributions
        // This assumes you have a 'contributions' relationship on your User model.
        // Example: total_contributions = $user->contributions()->sum('amount');
        // $total_contributions = 50000; // Replace with your actual calculation
        // Calculate total contributions for the authenticated user
        $total_contributions = $user->contributions()->sum('amount');
        // 2. Calculate Available Loan Balance
        // This logic depends on your loan management system.
        // Example: available_loan_balance = calculate_available_loan_based_on_contributions($total_contributions);
        $available_loan_balance = 30000; // Replace with your actual calculation

        // Calculate the maximum available loan amount
        $available_loan_amount = $total_contributions * 2;
        // 3. Calculate the Next Payment Amount (if any)
        // This logic depends on your loan payment schedule.
        // Example: next_payment_amount = $user->loans()->active()->first()->next_payment_amount;
        $next_payment_amount = 0; // Replace with your actual calculation
        $pending_for_approval = 0;
        $lastRow = null; // Initialize a variable to store the last row

        foreach ($user->approvals as $approval){

            if ($approval->status =='approved'){
                $next_payment_amount = $approval->loanTier->contribution_amount; // Replace with your actual calculation
            }elseif($approval->status =='pending'){
                $pending_for_approval ++;
            }

        }

        $current_tier = ContributionApprovals::where('user_id',user_id())->where('status','approved')->latest()->first();
        //  dump($current_tier);
        // Pass all the necessary variables to the dashboard view
        $isLoanEligible = $this->isLoanEligible(); // Call the new method

        return view('user.dashboard', compact('user', 'total_contributions', 'available_loan_balance', 'available_loan_amount', 'next_payment_amount','loan_tiers', 'isLoanEligible','pending_for_approval','current_tier'));
    }
    /**
     * Show the logged-in user's contributions dashboard.
     */
    public function myContributions()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Fetch all contributions for the user, ordered by a recent date
        $contributions = Contribution::where('user_id', $user->id)
                                    ->orderBy('created_at', 'desc')
                                    ->get();

        return view('my-contributions', compact('contributions'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
     public function store(Request $request)
    {
        // 1. Validation



        $CA = ContributionApprovals::create([
            'user_id' => user_id(),
            'loan_tier_id' => $request->loan_tier_id,
        ]);
        // 4. (Optional) Log the user in and redirect
        // Auth::login($user);

        return redirect()->route('user.dashboard')->with('success', 'تم التقديم بنجاح! يرجى انتظار موافقة المسؤول.');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
    public function contributions()
    {
        // Get the authenticated user with their contributions, ordered by the latest
        // $user = Auth::user()->load('contributions');
        $user = User::where('id_number', id_number())->with('contributions')->orderByDesc('id')->first();
        $contributions = $user->contributions;
        return view('user.contributions.index', compact('contributions'));
    }

    /**
     * Check if the user is eligible for a loan.
     */
    protected function isLoanEligible()
    {
        $user = Auth::user();
        $user = User::where('id_number', id_number())->first();
        // Check if the user has a full year of membership
        $membershipDuration = $user->created_at->diffInMonths(\Carbon\Carbon::now());

        // Check if the user has at least 12 contributions
        $contributionCount = $user->contributions()->where('type', 'additional_contribution')->count();

        // The user must have been a member for at least 12 months
        // AND have made at least 12 monthly contributions.
        if ($membershipDuration >= 12 && $contributionCount >= 12) {
            return true;
        }

        return false;
    }
     public function showLoanRequestForm()
    {
        $user = Auth::user()->load('contributions');
        // $user = User::where('id_number', id_number())->get();
        // dd($user);

        // Check for existing pending loan requests to prevent duplicates
        $hasPendingRequest = ContributionApprovals::where('user_id', $user->id)
                                                 ->where('type', 'loan_request')
                                                 ->where('status', 'pending')
                                                 ->exists();

        // If a pending request exists, redirect the user back with an error
        if ($hasPendingRequest) {
            return redirect()->route('user.dashboard')->with('error', 'لديك طلب قرض معلق بالفعل.');
        }

        // Check if the user is loan eligible (using the method we built)
        $isLoanEligible = $this->isLoanEligible();

        if (!$isLoanEligible) {
            return redirect()->route('user.dashboard')->with('error', 'أنت غير مؤهل لتقديم طلب قرض في الوقت الحالي.');
        }
        // Calculate the user's total contributions
        $total_contributions = $user->contributions()->sum('amount');
        // Fetch only the loan tiers that the user is eligible for
        $eligibleLoanTiers = LoanTier::where('contribution_min', '<=', $total_contributions)->get();
        // dump($total_contributions);
        // dump($eligibleLoanTiers);

        // If no eligible tiers are found, redirect the user back.
        if ($eligibleLoanTiers->isEmpty()) {
            return redirect()->route('user.dashboard')->with('error', 'رصيدك الحالي لا يؤهلك لأي فئة قرض.');
        }

        return view('user.loans.request', compact('eligibleLoanTiers','total_contributions'));
    }
    /**
     * Store the new loan request in the database.
     */
    public function storeLoanRequest(Request $request)
    {
        $user = Auth::user();

        // Check for existing pending requests again to prevent double submission
        $hasPendingRequest = ContributionApprovals::where('user_id', $user->id)
                                                 ->where('type', 'loan_request')
                                                 ->where('status', 'pending')
                                                 ->exists();

        if ($hasPendingRequest) {
            return redirect()->route('user.dashboard')->with('error', 'لديك طلب قرض معلق بالفعل.');
        }

        // The eligibility check should happen on the GET request, but it's good practice to re-check
        // a final time before processing the request, just in case.
        $isLoanEligible = $this->isLoanEligible();

        if (!$isLoanEligible) {
            return redirect()->route('user.dashboard')->with('error', 'أنت غير مؤهل لتقديم طلب قرض في الوقت الحالي.');
        }

        // Validate the request data
        $request->validate([
            'loan_tier_id' => 'required|exists:loan_tiers,id',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Create the new contribution approval record
        ContributionApprovals::create([
            'user_id' => $user->id,
            'loan_tier_id' => $request->input('loan_tier_id'),
            'status' => 'pending',
            'type' => 'loan_request',
            'notes' => $request->input('notes'),
        ]);
        Loan::create([
            'user_id' => $user->id,
            'loan_tier_id' => $request->input('loan_tier_id'),
            'status' => 'pending',
        ]);
        return redirect()->route('user.dashboard')->with('success', 'تم إرسال طلب القرض بنجاح. سيتم مراجعته من قبل الإدارة.');
    }
      /**
     * Show the logged-in user's loan dashboard.
     */
    public function myLoan()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Find the user's active loan (if any)
        // We will assume a user has only one active loan at a time
        $activeLoan = Loan::where('user_id', $user->id)
                          ->where('status', '!=', 'finished')
                          ->first();
        // dump($user);
         // Fetch all loans for the user, ordered by a recent date
        $loans = Loan::where('user_id', $user->id)
                     ->orderBy('request_date', 'desc')
                     ->get();
        $repayments = null;
        if ($activeLoan) {
            // If an active loan exists, get its repayments
            $repayments = $activeLoan->repayments()->orderBy('payment_date', 'desc')->get();
        }

        return view('my-loan', compact('activeLoan', 'repayments','loans'));
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
