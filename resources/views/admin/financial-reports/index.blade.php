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
</div>
@endsection
