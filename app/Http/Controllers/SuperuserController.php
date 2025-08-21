<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ContributionApprovals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperuserController extends Controller
{
    /**
     * Show the super user login form.
     */
    public function showLoginForm()
    {
        return view('superuser.login');
    }

    /**
     * Handle the super user authentication attempt.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials) && Auth::user()->is_admin) {
            $request->session()->regenerate();
            return redirect()->intended('/superuser/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records or you are not an administrator.',
        ])->onlyInput('email');
    }

    /**
     * Display the list of pending registration requests.
     */
    public function dashboard()
    {
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

        return view('superuser.dashboard', [
            'total_users' => $total_users,
            'pending_requests' => $pending_requests,
            'total_contributions' => $total_contributions,
            'total_loans' => $total_loans,
            'pendingApprovals' => $pendingApprovals,
        ]);
    }

    /**
     * Approve a user registration.
     */
    public function approveUser(User $user)
    {
        $user->is_approved = true;
        $user->save();

        return redirect()->back()->with('success', 'تمت الموافقة على طلب المستفيد.');
    }

    /**
     * Log the super user out.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
