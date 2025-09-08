@extends('layout.app')

@section('content')
<div class="container mt-5">
    <h2>سجل المساهمات الخاصة بي</h2>
    <hr>

    @if (count($contributions) > 0)
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                إجمالي المساهمات
            </div>
            <div class="card-body">
                <h4 class="text-center">{{ number_format($contributions->sum('amount'), 2) }} ريال</h4>
            </div>
        </div>

        <h3 class="mt-4">تفاصيل المساهمات</h3>
        <table class="table table-striped table-bordered">
            <thead class="bg-light">
                <tr>
                    <th>المبلغ</th>
                    <th>تاريخ المساهمة</th>
                    <th>ملاحظات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($contributions as $contribution)
                    <tr>
                        <td>{{ number_format($contribution->amount, 2) }} ريال</td>
                        <td>{{ $contribution->created_at }}</td>
                        <td>{{ $contribution->notes ?? 'لا توجد ملاحظات.' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-warning text-center">
            لم يتم تسجيل أي مساهمات لك بعد.
        </div>
    @endif
</div>
@endsection
