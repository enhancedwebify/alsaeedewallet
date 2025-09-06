<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contribution;
use App\Models\User;
use App\Models\ContributionApprovals;
use App\Models\LoanTier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory; // You must install the required package.


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
     * Show the form for uploading a bank statement file.
     */
    public function showUploadForms()
    {
        // echo "dd";
        echo 'www';
        return view('admin.contributions.upload');
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
        $user = User::where('id_number', id_number())->with('loanTier')->first();
        // Check for existing pending requests of this type to prevent duplicates
        // Get the monthly installment from the user's active loan tier
        // If no tier is set, we can assume a default of 0.
        // dd($user);
        $currentMonthlyContribution = $user->loanTier?->monthly_installment ?? 0;
        // Check if the current monthly contribution is already 10,000 SAR or more
        if ($currentMonthlyContribution >= 10000) {
            return redirect()->back()->with('error', 'لا يمكن تقديم طلب لتغيير الشريحة. مساهمتك الشهرية الحالية هي الحد الأقصى المسموح به (10,000 ريال).');
        }

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
     * Import contributions from a bank statement file.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:10240', // 10MB
        ]);

        $filePath = $request->file('file')->getRealPath();

        try {
            // Load the spreadsheet file
            $spreadsheet = IOFactory::load($filePath);
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray(null, true, true, true);

           // Find the row that contains the transaction data headers
            $headerRowIndex = 0;
            foreach ($data as $rowIndex => $row) {
                if (in_array("تٝاصيل العملية\nTransaction Description", $row)) {
                    $headerRowIndex = $rowIndex;
                    break;
                }
            }

            if ($headerRowIndex === 0) {
                return redirect()->back()->with('error', 'لم يتم العثور على عنوان "تٝاصيل العملية" في الملف.');
            }

            // Map columns based on the header row
            $headers = $data[$headerRowIndex];
            $amountColumn = array_search("دائن/مدين\nCredit/Debit", $headers);
            $descriptionColumn = array_search("تٝاصيل العملية\nTransaction Description", $headers);
            $dateColumn = array_search("تاريخ العملية\nTransaction Date", $headers);

            if (!$amountColumn || !$descriptionColumn || !$dateColumn) {
                return redirect()->back()->with('error', 'تنسيق الملف غير صحيح. الأعمدة المطلوبة مفقودة.');
            }

            // Start processing from the row after the header
            $rows = array_slice($data, $headerRowIndex + 1);

            $importedCount = 0;
            $failedIban = [];

            DB::beginTransaction();

            foreach ($data as $row) {
                // Skip empty or invalid rows
                if (empty($row[$amountColumn]) || empty($row[$descriptionColumn]) || empty($row[$dateColumn])) {
                    continue;
                }

                $amount = (float) str_replace(['SAR ', '،', ','], ['', '', ''], $row[$amountColumn]);
                $description = $row[$descriptionColumn];
                $transactionDate = $row[$dateColumn];
                // Remove all characters except digits and the decimal point
                $clean_price_string = preg_replace("/[^0-9.]/", "",str_replace(['SAR ', '،', ','], ['', '', ''], $row[$amountColumn]) );

                // Convert the cleaned string to a float
                $amount = (float)$clean_price_string;
                // dump($row[$amountColumn]);
                // dump($amount);

                // Extract the IBAN from the description using a regular expression
                preg_match('/SA\d{22}/', $description, $matches);
                $iban = $matches[0] ?? null;
                dump($iban);
                if ($iban) {
                    // Find the user by their IBAN
                    $user = User::where('iban', $iban)->first();
                    dump($user->full_name);

                    if ($user) {
                        // Check for duplicate transaction to prevent double import
                        $referenceId = 'imported-' . $iban . '-' . $transactionDate . '-' . $amount;
                        if (!Contribution::where('statement_reference_id', $referenceId)->exists()) {
                            Contribution::create([
                                'user_id' => $user->id,
                                'amount' => $amount,
                                'transaction_date' => \Carbon\Carbon::parse($transactionDate)->format('Y-m-d'),
                                'type' => 'contribution',
                                'statement_reference_id' => $referenceId
                            ]);
                            $importedCount++;
                        }
                    } else {
                        $failedIban[] = $iban;
                    }
                } else {
                    $failedIban[] = "IBAN not found in row: " . implode(', ', $row);
                }
            }

            DB::commit();

            $message = 'تم استيراد ' . $importedCount . ' مساهمة بنجاح.';
            if (!empty($failedIban)) {
                $message .= ' فشل العثور على مستخدمين لهذه الأيبانات: ' . implode(', ', array_unique($failedIban));
            }

            // return redirect()->back()->with('success', $message);
            dump($message);
        } catch (\Exception $e) {
            DB::rollBack();
            // return redirect()->back()->with('error', 'حدث خطأ أثناء معالجة الملف: ' . $e->getMessage());
        }
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
