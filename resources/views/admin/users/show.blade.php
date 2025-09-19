@extends('layout.app')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>ملف العضو: {{ $user->name }}</h2>
        <a href="{{ route('admin.users.index') }}" class="btn btn-primary">العودة إلى الأعضاء</a>
    </div>
    <hr>

    <div class="card mb-4">
        <div class="card-header bg-main text-white">
            تفاصيل العضو
        </div>
        <div class="card-body">
            <p><strong>الاسم الكامل:</strong> {{ $user->full_name }}</p>
            <p><strong>البريد الإلكتروني:</strong> {{ $user->email }}</p>
            <p><strong>حالة الحساب:</strong>
                @if ($user->is_admin==1)
                    <span class="badge bg-primary">مدير</span>
                @else
                    <span class="badge bg-secondary">عضو</span>
                @endif
            </p>
            <p><strong>تاريخ التسجيل:</strong> {{ $user->created_at->format('Y-m-d') }}</p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-main text-white">
            سجل القروض
        </div>
        <div class="card-body">
            @if ($user->loans->count() > 0)
                <table id="myTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>المبلغ</th>
                            <th>المبلغ المسدد</th>
                            <th>المتبقي</th>
                            <th>الحالة</th>
                            <th>تاريخ الطلب</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user->loans as $loan)
                            <tr>
                                <td>{{ number_format($loan->amount, 2) }}</td>
                                <td>{{ number_format($loan->total_repaid_amount, 2) }}</td>
                                <td>{{ number_format($loan->amount - $loan->total_repaid_amount, 2) }}</td>
                                <td>
                                    @if ($loan->status == 'pending')
                                        <span class="badge bg-warning">قيد المراجعة</span>
                                    @elseif ($loan->status == 'active')
                                        <span class="badge bg-success">نشط</span>
                                    @else
                                        <span class="badge bg-info">منتهي</span>
                                    @endif
                                </td>
                                <td>{{ $loan->request_date }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-info text-center">لا يوجد سجل قروض لهذا العضو.</div>
            @endif
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-success text-white">
            سجل المساهمات
        </div>
        <div class="card-body">
            @if ($user->contributions->count() > 0)
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>المبلغ</th>
                            <th>التاريخ</th>
                            <th>ملاحظات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user->contributions as $contribution)
                            <tr>
                                <td>{{ number_format($contribution->amount, 2) }}</td>
                                <td>{{ $contribution->contribution_date }}</td>
                                <td>{{ $contribution->notes ?? 'لا توجد ملاحظات.' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-info text-center">لا يوجد سجل مساهمات لهذا العضو.</div>
            @endif
        </div>
    </div>
</div>
@endsection
