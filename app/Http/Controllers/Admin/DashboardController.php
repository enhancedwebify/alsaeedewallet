<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LoanTier; // Don't forget to import the LoanTier model
use App\Models\ContributionApprovals; // Don't forget to import the LoanTier model

class DashboardController extends Controller
{
    //
    public function showApproval($id)
    {
        // Find the approval request by its ID and eagerly load the related user data
        $approval = ContributionApprovals::with('user')->findOrFail($id);

        // Get all available loan tiers to display in the approval form
        $loanTiers = LoanTier::all();

        return view('admin.approvals.show', compact('approval', 'loanTiers'));
    }
     /**
     * Process an approval or rejection request.
     */
    public function processApproval(Request $request, $id)
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
