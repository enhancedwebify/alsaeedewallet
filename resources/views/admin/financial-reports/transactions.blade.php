@extends('layout.app')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>سجل المعاملات المالية</h2>
    </div>
    <hr>

    @if ($allTransactions->count() > 0)
        <table class="table table-striped table-bordered">
            <thead class="bg-light">
                <tr>
                    <th>النوع</th>
                    <th>اسم العضو</th>
                    <th>المبلغ</th>
                    <th>التاريخ</th>
                    <th>ملاحظات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($allTransactions as $transaction)
                    <tr>
                        <td>
                            @if ($transaction->type == 'contribution')
                                <span class="badge bg-success">مساهمة</span>
                            @else
                                <span class="badge bg-primary">سداد قرض</span>
                            @endif
                        </td>
                        <td>{{ $transaction->user_name ?? ($transaction->loan->user->full_name ?? 'غير معروف') }}</td>
                        <td>{{ number_format($transaction->amount_paid ?? $transaction->amount, 2) }} ريال</td>
                        <td>{{ \Carbon\Carbon::parse($transaction->date)->format('Y-m-d H:i') }}</td>
                        <td>{{ $transaction->notes ?? 'لا توجد ملاحظات.' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-warning text-center">
            لا توجد أي معاملات مالية مسجلة.
        </div>
    @endif
</div>
@endsection
