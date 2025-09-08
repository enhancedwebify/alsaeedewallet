<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
 <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>طلب قرض</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <style>
        .card {
            border-radius: 1rem;
            border: 1px solid #e9ecef;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            margin-bottom: 1.5rem;
        }
        .text-main {
            color: #551d7c; /* Assuming this is your main purple color */
        }
        .bg-main-light {
            background-color: #f7f2fb;
        }
        .progress-bar-loan {
            background-color: #f5c53c;
        }
          /* This is a simple fix for the main content area on desktop */
        @media (min-width: 768px) {
            body {
                padding-right: 250px; /* Adjust this value to match your sidebar's width */
            }
            .main-content {
                padding-left: 15px; /* Adds a small gutter */
                padding-right: 15px;
            }
        }
        /* Mobile: The offcanvas container is handled by Bootstrap's JS */
    </style>
    @include('layout.head')
</head>
<body>
    <div class="d-flexs" id="wrapper">
        @include('layout.sidebar')

        <div id="page-content-wrapper">
            {{-- @include('layout.header') --}}

            <div class="container py-4">
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h2 class="text-main fw-bold">تقديم طلب قرض</h2>
                            <a href="{{ route('user.dashboard') }}" class="btn btn-sm btn-primary">العودة إلى لوحة التحكم</a>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8 mx-auto">
                        <div class="card shadow border-0 p-4">
                            <div class="alert alert-info">
                                رصيدك الحالي من المساهمات: **{{ number_format($total_contributions, 2) }} ريال**
                            </div>
                            <form action="{{ route('user.loans.store') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label for="loan_tier" class="form-label">اختر فئة القرض المناسبة:</label>
                                    <select name="loan_tier_id" id="loan_tier_id" class="form-select" required>
                                        <option value="">اختر من القائمة</option>
                                        @foreach ($eligibleLoanTiers as $tier)
                                            <option value="{{ $tier->id }}">
                                                {{ 'الفئة ' . $tier->tier_number . ' - ' . 'القرض: ' . $tier->loan_amount_min . ' إلى ' . $tier->loan_amount_max . ' ريال' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="notes" class="form-label">ملاحظات إضافية (اختياري):</label>
                                    <textarea name="notes" id="notes" class="form-control" rows="3"></textarea>
                                </div>

                                <button type="submit" class="btn btn-primary">إرسال الطلب</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- @include('layout.footer') --}}
</body>
</html>
