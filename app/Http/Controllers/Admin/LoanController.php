<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LoanTier;
use App\Models\Loan;
use App\Models\LoanRepayment;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
     /**
     * Display a specific loan and its repayments.
     */
    public function show(Loan $loan)
    {
        $repayments = $loan->repayments()->orderBy('payment_date', 'desc')->get();

        return view('admin.loans.show', compact('loan', 'repayments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    /**
     * Records a repayment for a specific loan.
     */
    public function repay(Request $request, Loan $loan)
    {
        $request->validate([
            'amount_paid' => 'required|numeric|min:1',
            'notes' => 'nullable|string',
        ]);
         // Calculate the outstanding balance
        $outstandingBalance = $loan->amount - $loan->total_repaid_amount;

        $amountPaid = $request->input('amount_paid');

        // Ensure the payment does not exceed the outstanding balance
        if ($amountPaid > $outstandingBalance) {
            return redirect()->back()->with('error', 'المبلغ المدفوع يتجاوز الرصيد المتبقي للقرض.');
        }

        DB::beginTransaction();

        try {
            // Record the repayment using the correct column names
            LoanRepayment::create([
                'loan_id' => $loan->id,
                'amount_paid' => $amountPaid,
                'payment_date' => now(), // Matches your column
                'notes' => $request->input('notes'),
            ]);

            // Update the outstanding balance
            // Update the total repaid amount for the loan
            $loan->total_repaid_amount += $amountPaid;

            // Check if the loan is fully paid off
            if ($loan->total_repaid_amount >= $loan->amount) {
                $loan->status = 'finished';
                $message = 'تم تسجيل السداد بنجاح. تم سداد القرض بالكامل.';
            } else {
                $message = 'تم تسجيل السداد بنجاح.';
            }
            $loan->save();

            DB::commit();

            return redirect()->back()->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'حدث خطأ أثناء تسجيل السداد: ' . $e->getMessage());
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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
