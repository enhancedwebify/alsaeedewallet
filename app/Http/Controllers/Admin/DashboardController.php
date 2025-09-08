<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LoanTier; // Don't forget to import the LoanTier model
use App\Models\Loan; // Don't forget to import the LoanTier model
use App\Models\User; // Don't forget to import the LoanTier model
use App\Models\ContributionApprovals; // Don't forget to import the LoanTier model
use App\Models\Contribution; // Don't forget to import the LoanTier model
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //
    public function index (){
        // Fetch users who are not yet approved
        $pendingRequests = User::where('is_approved', false)->get();
        // return view('superuser.dashboard', compact('pendingRequests'));
         // Fetch data for the dashboard cards
        $total_users = User::count();
        $pending_requests = ContributionApprovals::where('status', 'pending')->count();

        // Assuming you have a 'contributions' and 'loans' table
        $total_contributions = 0; // Or Contribution::sum('amount');
        $total_loans = 0; // Or Loan::sum('amount');

        // Fetch the pending requests for the table
        $pendingApprovals = ContributionApprovals::with('user')->where('status', 'pending')->latest()->take(10)->get();

        // Fetch the latest contributions for the contributions table
        $latestContributions = Contribution::with('user')->latest()->orderBy('created_at','desc')->take(10)->get();
        ##########
         // Calculate the total amount of contributions
        $totalContributions = Contribution::sum('amount');

        // Calculate the total amount of loans disbursed
        $totalLoans = Loan::where('status', '!=', 'pending')->sum('amount');
          // Fetch all active and pending loans for the detailed report
        $activeLoans = Loan::with('user') // Eager load the user relationship
                          ->where('status', '!=', 'finished')
                          ->orderBy('request_date', 'asc')
                          ->get();
        // Calculate the fund balance
        $fundBalance = $totalContributions - $totalLoans;

        return view('superuser.dashboard', [
            'total_users' => $total_users,
            'pending_requests' => $pending_requests,
            'total_contributions' => $total_contributions,
            'total_loans' => $total_loans,
            'pendingApprovals' => $pendingApprovals,
            'latestContributions' => $latestContributions,
            'totalContributions' => $totalContributions,
            'totalLoans' => $totalLoans,
            'fundBalance' => $fundBalance,
            'activeLoans' => $activeLoans,
        ]);
    }
    public function showApproval($id)
    {
        // Find the approval request by its ID and eagerly load the related user data
        $approval = ContributionApprovals::with(['user', 'loanTier'])->findOrFail($id);

        // Check if the approval record exists
        if (!$approval) {
            // If not, redirect back with an error message
            return redirect()->route('admin.approvals.pending')
                             ->with('error', 'طلب الموافقة غير موجود.');
        }
        $isGuarantorRequired = false;

        // This logic only applies to loan requests
        if ($approval->type === 'loan_request') {
            // Calculate the user's total contributions
            $totalContributions = $approval->user->contributions()->sum('amount');

            // Get the requested loan amount (using the min as a default)
            $requestedLoanAmount = $approval->loanTier->loan_amount_min;

            // Determine if a guarantor is required based on the legal document's rule
            if ($requestedLoanAmount > $totalContributions) {
                $isGuarantorRequired = true;
            }
        }

        // Pass all users to the view for the guarantor dropdown
        $allUsers = User::all();
        // Get all available loan tiers to display in the approval form
        $loanTiers = LoanTier::all();

        // This is a temporary line to help us debug
        // dump($approval->type);
        if($approval->type === 'loan_request'){
            // dump([
            //     'requested_loan_amount' => $requestedLoanAmount,
            //     'total_contributions' => $totalContributions,
            //     'is_guarantor_required' => $isGuarantorRequired,
            // ]);
            return view('admin.approvals.show1', compact('approval', 'loanTiers','isGuarantorRequired', 'allUsers'));
        }elseif($approval->type === 'contribution'){
            return view('admin.approvals.show1', compact('approval', 'loanTiers'));

        }elseif($approval->type === 'tier_change_request'){
            $user_id = $approval->user->id;
            $current_tier = ContributionApprovals::where('user_id',$user_id)->where('status','approved')->latest()->first();
            return view('admin.approvals.show1', compact('approval', 'loanTiers','current_tier'));

        }
    }
     /**
     * Process an approval request (approve/reject).
     */
    public function processApproval(Request $request, $id)
    {
        $approval = ContributionApprovals::findOrFail($id);

        // Prevent processing an already processed request
        if ($approval->status !== 'pending') {
            return redirect()->route('admin.dashboard')->with('error', 'تمت معالجة هذا الطلب بالفعل.');
        }
// dd('ss');
        // Validate the admin's action and guarantor for loan requests
        $request->validate([
            'action' => 'required|in:approve,reject',
            // 'guarantor_id' => 'required_if:action,approve|exists:users,id', // Required only for loan approval
        ]);

        $action = $request->input('action');

        DB::beginTransaction();

        try {
            if ($action === 'approve') {
                if ($approval->type === 'loan_request') {
                    // Get the loan tier details
                    $loanTier = $approval->loanTier;

                    // The legal document states a specific loan amount based on contributions.
                    // Let's assume for this code that the loan amount is the minimum of the tier for now.
                    // A more advanced system would allow the admin to specify the exact amount within the range.
                    $loanAmount = $loanTier->loan_amount_min;

                    // Create a new loan record
                    Loan::create([
                        'user_id' => $approval->user_id,
                        'loan_tier_id' => $approval->loan_tier_id,
                        'guarantor_id' => $request->input('guarantor_id'),
                        'loan_amount' => $loanAmount,
                        'outstanding_balance' => $loanAmount,
                        'is_approved' => true,
                        'monthly_payment' => $loanTier->monthly_payment_amount,
                        'loan_date' => now(),
                    ]);

                    // Update the user's loan_tier_id to reflect the new approved tier
                    $approval->user->update(['loan_tier_id' => $approval->loan_tier_id]);

                    // Update the approval status
                    $approval->update(['status' => 'approved']);

                    $message = 'تمت الموافقة على طلب القرض بنجاح.';

                } elseif ($approval->type === 'tier_change_request') {
                    // Update the user's loan_tier_id to reflect the new tier
                    $approval->user->update(['loan_tier_id' => $approval->loan_tier_id]);

                    // Update the approval status
                    $approval->update(['status' => 'approved','notes' => $request->input('notes')]);

                    $message = 'تمت الموافقة على طلب تغيير الشريحة بنجاح.';
                } elseif ($approval->type === 'contribution') {
                    // Update the user's loan_tier_id to reflect the new tier
                    $approval->user->update(['loan_tier_id' => $approval->loan_tier_id,'is_approved' => 1]);

                    // Update the approval status
                    $approval->update(['status' => 'approved','notes' => $request->input('notes')]);

                    $message = 'تمت الموافقة على طلب المساهمة بنجاح.';
                }

            } elseif ($action === 'reject') {
                $approval->update(['status' => 'rejected']);
                $message = 'تم رفض الطلب بنجاح.';
            }

            DB::commit();
            return redirect()->route('superuser.dashboard')->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }
     /**
     * Process an approval or rejection request.
     */
    public function processApproval1(Request $request, $id)
    {
        $approval = ContributionApprovals::findOrFail($id);

        // Check if the approval is not already processed
        if ($approval->status !== 'pending') {
            return redirect()->route('superuser.dashboard')->with('error', 'هذا الطلب تم التعامل معه بالفعل.');
        }

        // Get the action from the form (approve or reject)
        $action = $request->input('action');

        if ($action === 'approve') {
            // Validate that a loan tier was selected
            $request->validate([
                'loan_tier_id' => 'required|exists:loan_tiers,id',
            ]);

            // Update the approval record
            $approval->status = 'approved';
            $approval->loan_tier_id = $request->input('loan_tier_id');
            $approval->notes = $request->input('notes');
            $approval->save();

            // Find the related user and update their status
            $user = $approval->user;
            if ($user) {
                $user->loan_tier_id = $request->input('loan_tier_id');
                $user->is_approved = 1; // 1 means approved
                $user->save();
            }

            return redirect()->route('superuser.dashboard')->with('success', 'تمت الموافقة على الطلب بنجاح.');

        } elseif ($action === 'reject') {
            // Update the approval record
            $approval->status = 'rejected';
            $approval->notes = $request->input('notes');
            $approval->save();

            // For a rejection, we don't update the user's is_approved status or loan tier

            return redirect()->route('superuser.dashboard')->with('success', 'تم رفض الطلب بنجاح.');
        }

        return redirect()->back()->with('error', 'إجراء غير صالح.');
    }
}
