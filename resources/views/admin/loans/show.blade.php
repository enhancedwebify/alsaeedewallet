@extends('layout.app')

@section('content')
<div class="container">
    <h2>تفاصيل القرض</h2>
    <hr>

    <div class="card mb-4">
        <div class="card-header">
            تفاصيل القرض
        </div>
        <div class="card-body">
            <p><strong>اسم العضو:</strong> {{ $loan->user->name }}</p>
            @php
                $outstanding_balance = $loan->amount - $loan->total_repaid_amount;
            @endphp
            <p><strong>المبلغ المطلوب:</strong> {{ number_format($loan->amount, 2) }} ريال</p>
            <p><strong>المبلغ المتبقي:</strong> {{ number_format($outstanding_balance, 2) }} ريال</p>
            <p><strong>الحالة:</strong> {{ $loan->is_approved ? 'قرض نشط' : 'قرض منتهي' }}</p>
        </div>
    </div>

    <h3>تسجيل سداد جديد</h3>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.loans.repay', $loan) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="amount_paid">مبلغ السداد:</label>
                    <input type="number" class="form-control" id="amount_paid" name="amount_paid" step="0.01" required>
                </div>
                <div class="form-group mt-3">
                    <label for="notes">ملاحظات:</label>
                    <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary mt-3">تسجيل السداد</button>
            </form>
        </div>
    </div>

    <h3>سجل السدادات</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>المبلغ المسدد</th>
                <th>تاريخ السداد</th>
                <th>ملاحظات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($repayments as $repayment)
                <tr>
                    <td>{{ number_format($repayment->amount_paid, 2) }}</td>
                    <td>{{ $repayment->payment_date }}</td>
                    <td>{{ $repayment->notes }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">لم يتم تسجيل أي سداد لهذا القرض بعد.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
