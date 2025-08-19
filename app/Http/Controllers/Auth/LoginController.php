<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\ContributionApprovals;

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function create()
    {
        return view('auth.login');
    }
    /**
     * Show the login form.
     */
    public function login_page()
    {
        return view('user/login');
    }
    public function user_login(Request $request)
    {
        // 1. Validate the user's input
        $request->validate([
            'id_number' => 'required|string',
            'password' => 'required|string',
        ]);

        // 2. Prepare the credentials
        $credentials = [
            'id_number' => $request->id_number,
            'password' => $request->password,
        ];

        // 3. Use Auth::attempt() to securely log in the user
        // This method automatically hashes the password and compares it to the database's hashed password
        if (Auth::attempt($credentials)) {
            // Log in was successful
            $user = Auth::user(); // Get the authenticated user
            $request->session()->regenerate();

            $request->session()->put('user_id', $user->id); // Or $request->session()->put('user', $user);
            $request->session()->put('id_number', $user->id_number); // Or $request->session()->put('user', $user);
            $request->session()->put('email', $user->email); // Or $request->session()->put('user', $user);
            $request->session()->put('full_name', $user->full_name); // Or $request->session()->put('user', $user);

            return redirect()->intended('user/dashboard'); // Redirect to a dashboard or intended URL
        }

        // 4. If login fails, redirect back with an error message
        return back()->withErrors([
            'id_number' => 'رقم الهوية أو كلمة المرور غير صحيحة.',
        ])->withInput();
    }
    public function user_dashboard()
    {
        // $requests = User::where('id_number',id_number())->with('loanTier')->first();
        // return view('user.dashboard',compact('requests'));
        // Fetch the user's data along with the loan tier relationship
        $user = User::where('id_number', id_number())->with('approvals.loanTier')->first();
        // $ca = ContributionApprovals::where('user_id',$user->id)->get();
        // dump($user);
        // 1. Calculate Total Contributions
        // This assumes you have a 'contributions' relationship on your User model.
        // Example: total_contributions = $user->contributions()->sum('amount');
        $total_contributions = 50000; // Replace with your actual calculation

        // 2. Calculate Available Loan Balance
        // This logic depends on your loan management system.
        // Example: available_loan_balance = calculate_available_loan_based_on_contributions($total_contributions);
        $available_loan_balance = 30000; // Replace with your actual calculation

        // 3. Calculate the Next Payment Amount (if any)
        // This logic depends on your loan payment schedule.
        // Example: next_payment_amount = $user->loans()->active()->first()->next_payment_amount;
        $next_payment_amount = 1500; // Replace with your actual calculation

        // Pass all the necessary variables to the dashboard view
        return view('user.dashboard', compact('user', 'total_contributions', 'available_loan_balance', 'next_payment_amount'));
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/dashboard'); // Redirect to a dashboard or home page
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Log the user out of the application.
     */
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/'); // Redirect to the home page
    }
}
