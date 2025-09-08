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

        return view('admin.financial-reports.index', compact('totalContributions', 'totalLoans', 'fundBalance'));
    }
}
