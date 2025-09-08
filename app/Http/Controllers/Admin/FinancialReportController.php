<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContributionApprovals;
use App\Models\Contribution;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\LoanTier;
use App\Models\Loan;
use App\Models\LoanRepayment;

class FinancialReportController extends Controller
{
    /**
     * Show the main financial reports dashboard.
     */
    public function index()
    {
        // Calculate the total amount of contributions
        $totalContributions = Contribution::sum('amount');

        // Calculate the total amount of loans disbursed
        $totalLoans = Loan::where('status', '!=', 'pending')->sum('amount');

        // Calculate the fund balance
        $fundBalance = $totalContributions - $totalLoans;
           // Fetch all active and pending loans for the detailed report
        $activeLoans = Loan::with('user') // Eager load the user relationship
                          ->where('status', '!=', 'finished')
                          ->orderBy('request_date', 'asc')
                          ->get();
        return view('admin.financial-reports.index', compact('totalContributions', 'totalLoans', 'fundBalance','activeLoans'));
    }
     /**
     * Show the financial transactions log.
     */
    public function transactions()
    {
        // Fetch all contributions
        $contributions = Contribution::with('user')->get()->map(function ($item) {
            $item->type = 'contribution';
            $item->date = $item->contribution_date;
            return $item;
        });

        // Fetch all loan repayments
        $repayments = LoanRepayment::with('loan.user')->get()->map(function ($item) {
            $item->type = 'repayment';
            $item->user_id = $item->loan->user->id;
            $item->user_name = $item->loan->user->name;
            $item->date = $item->payment_date;
            return $item;
        });

        // Merge the collections and sort by date in descending order
        $allTransactions = $contributions->concat($repayments)->sortByDesc('date');

        return view('admin.financial-reports.transactions', compact('allTransactions'));
    }
}
