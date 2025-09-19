<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ContributionApprovals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Contribution; // Don't forget to import the Contribution model

class SuperuserController extends Controller
{
    /**
     * Show the super user login form.
     */
    public function showLoginForm()
    {
        // Check if the admin is already logged in
        if (Auth::check() && Auth::user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
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
        // dd($request->all());

        if (Auth::attempt($credentials) && Auth::user()->is_admin) {
            $user = Auth::user();
            // dump($user);
            $request->session()->regenerate();
            $request->session()->put('user_id', $user->id); // Or $request->session()->put('user', $user);
            $request->session()->put('id_number', $user->id_number); // Or $request->session()->put('user', $user);
            $request->session()->put('email', $user->email); // Or $request->session()->put('user', $user);
            $request->session()->put('full_name', $user->full_name); // Or $request->session()->put('user', $user);
            $request->session()->put('is_admin', $user->is_admin); // Or $request->session()->put('user', $user);

            return redirect()->intended('admin/dashboard'); // Redirect to a dashboard or intended URL
            // return redirect()->intended('/superuser/dashboard');
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

        // Fetch the latest contributions for the contributions table
        $latestContributions = Contribution::with('user')->latest()->take(10)->get();

        return view('superuser.dashboard', [
            'total_users' => $total_users,
            'pending_requests' => $pending_requests,
            'total_contributions' => $total_contributions,
            'total_loans' => $total_loans,
            'pendingApprovals' => $pendingApprovals,
            'latestContributions' => $latestContributions,
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
