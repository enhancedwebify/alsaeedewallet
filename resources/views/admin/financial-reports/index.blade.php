@extends('layout.app')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>التقارير المالية</h2>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card text-center bg-main text-white">
                <div class="card-body">
                    <h5 class="card-title">إجمالي المساهمات</h5>
                    <p class="card-text fs-2">{{ number_format($totalContributions, 2) }}</p>
                    <p class="card-text">ريال</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center bg-dark text-white">
                <div class="card-body">
                    <h5 class="card-title">إجمالي القروض المصروفة</h5>
                    <p class="card-text fs-2">{{ number_format($totalLoans, 2) }}</p>
                    <p class="card-text">ريال</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">رصيد الصندوق الحالي</h5>
                    <p class="card-text fs-2">{{ number_format($fundBalance, 2) }}</p>
                    <p class="card-text">ريال</p>
                </div>
            </div>
        </div>
    </div>
     <h3 class="mt-5">القروض النشطة</h3>
    @if ($activeLoans->count() > 0)
        <table class="table table-striped table-bordered">
            <thead class="bg-light">
                <tr>
                    <th>اسم العضو</th>
                    <th>المبلغ الإجمالي للقرض</th>
                    <th>المبلغ المسدد</th>
                    <th>المبلغ المتبقي</th>
                    <th>الحالة</th>
                    <th>تاريخ الطلب</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($activeLoans as $loan)
                    <tr>
                        <td>{{ $loan->user->name }}</td>
                        <td>{{ number_format($loan->amount, 2) }} ريال</td>
                        <td>{{ number_format($loan->total_repaid_amount, 2) }} ريال</td>
                        <td>{{ number_format($loan->amount - $loan->total_repaid_amount, 2) }} ريال</td>
                        <td>
                            @if ($loan->status == 'pending')
                                قيد المراجعة
                            @else
                                نشط
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($loan->request_date)->format('Y-m-d') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-info text-center mt-4">
            لا توجد قروض نشطة حالياً.
        </div>
    @endif
</div>

@endsection
