@extends('layout.app')

@section('content')
<div class="container mt-5">
    <h2>لوحة تحكم القروض الخاصة بي</h2>

    <hr>

    @php
        $pendingLoan = $loans->firstWhere('status', 'pending');

    @endphp
      @if ($pendingLoan)
        <div class="alert alert-info text-center">
            لديك طلب قرض قيد المراجعة.
            <br>
            ستتلقى إشعارًا عند الموافقة عليه أو رفضه.
        </div>
    @elseif ($activeLoan)
        <div class="alert alert-warning text-center">
            لديك قرض نشط حالياً. لا يمكنك طلب قرض جديد حتى يتم سداد القرض السابق بالكامل.
        </div>
    @else
        <div class="alert alert-success text-center">
            <p>تهانينا! ليس لديك أي قروض نشطة. يمكنك طلب قرض جديد الآن.</p>
            <a href="{{ route('user.loans.request') }}" class="btn btn-success mt-2">
                طلب قرض جديد
            </a>
        </div>
    @endif
    @if (count($loans) > 0)
        @foreach ($loans as $loan)
            <div class="card mb-5">
                <div class="card-header bg-{{ $loan->status == 'finished' ? 'success' : 'primary' }} text-white">
                    <h4 class="mb-0">
                        @if ($loan->status == 'finished')
                            قرض منتهي
                        @else
                            قرض نشط
                        @endif
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>المبلغ الإجمالي للقرض:</strong> {{ number_format($loan->amount, 2) }} ريال</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>المبلغ المسدد:</strong> {{ number_format($loan->total_repaid_amount, 2) }} ريال</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>المبلغ المتبقي:</strong> {{ number_format($loan->amount - $loan->total_repaid_amount, 2) }} ريال</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>تاريخ طلب القرض:</strong> {{ \Carbon\Carbon::parse($loan->request_date)->format('Y-m-d') }}</p>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <h4>سجل السدادات</h4>
                    @if (count($loan->repayments) > 0)
                        <table class="table table-striped table-bordered">
                            <thead class="bg-light">
                                <tr>
                                    <th>المبلغ المسدد</th>
                                    <th>تاريخ السداد</th>
                                    <th>ملاحظات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($loan->repayments()->orderBy('payment_date', 'desc')->get() as $repayment)
                                    <tr>
                                        <td>{{ number_format($repayment->amount_paid, 2) }} ريال</td>
                                        <td>{{ $repayment->payment_date }}</td>
                                        <td>{{ $repayment->notes ?? 'لا توجد ملاحظات.' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-info text-center">
                            لم يتم تسجيل أي سداد لهذا القرض بعد.
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    @else
        <div class="alert alert-warning text-center">
            ليس لديك أي قروض مسجلة حالياً.
        </div>
    @endif
</div>
@endsection
