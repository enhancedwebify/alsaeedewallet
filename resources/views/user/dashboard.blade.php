<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم</title>
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
</head>
<body>
    @include('layout.sidebar')
    <div class="container mt-5">
        {{-- @include('layout.header') --}}

        @if (session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-main fw-bold">لوحة التحكم</h2>
        </div>
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card bg-main-light p-4 text-center">
                    <h5 class="card-title fw-bold">إجمالي المساهمات</h5>
                    <h2 class="card-text fw-bold text-main">{{ number_format($total_contributions ?? 0, 2) }} ريال</h2>
                    <p class="text-muted">آخر تحديث: اليوم</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4 text-center">
                    <h5 class="card-title fw-bold">الرصيد المتاح للقرض</h5>
                    <h2 class="card-text fw-bold">{{ number_format($available_loan_balance ?? 0, 2) }} ريال</h2>
                    <p class="text-muted">مبلغ قرضك الحالي</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4 text-center">
                    <h5 class="card-title fw-bold">قسط الشهر القادم</h5>
                    <h2 class="card-text fw-bold text-main">{{ number_format($next_payment_amount ?? 0, 2) }} ريال</h2>
                    <p class="text-muted">تاريخ الاستحقاق: 15 أغسطس</p>
                </div>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-md-8">
                <div class="card p-4 h-100 d-flex flex-column justify-content-center">
                    <div class="d-flex justify-content-around flex-wrap">
                        <a href="#" class="btn btn-lg btn-success fw-bold m-2" style="background-color: #38c172; border-color: #38c172;">
                            <i class="bi bi-wallet2"></i> إيداع مساهمة جديدة
                        </a>
                        <a href="#" class="btn btn-lg btn-warning fw-bold m-2" style="background-color: #ffc800; border-color: #ffc800;">
                            <i class="bi bi-cash-stack"></i> طلب قرض جديد
                        </a>
                        <a href="#" class="btn btn-lg btn-info fw-bold m-2" style="background-color: #17a2b8; border-color: #17a2b8;">
                            <i class="bi bi-arrow-right-circle"></i> سداد قسط
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4 h-100">
                    <h5 class="fw-bold">حالة الطلب</h5>
                    @foreach ($user->approvals as $approval)

                    <div class="fw-bold"><span class="fw-bold">الشريحة رقم : </span><span>{{$approval->loanTier->tier_number}} المساهمة {{$approval->loanTier->contribution_amount}} ريال مدة {{$approval->loanTier->contribution_period_months}} شهر</span></div>
                    @if ($approval->status=='approved')
                            <span class="badge bg-success py-2 px-3 fw-normal fs-6">تمت الموافقة على حسابك</span>
                        @else
                            <span class="badge bg-warning text-dark py-2 px-3 fw-normal fs-6">طلبك قيد المراجعة</span>
                        @endif
                        <p class="text-muted mt-2 mb-0">نحن نعمل على مراجعة طلبك وإعلامك بالنتيجة قريباً.</p>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card p-4">
                    <h4 class="card-title text-main fw-bold mb-3">بياناتي الشخصية</h4>
                    <div class="row">
                        <div class="col-8">
                            <h5 class="fw-bold mb-3">{{ $user->full_name }}</h5>
                            <p class="mb-1"><strong>رقم الهوية:</strong> {{ $user->id_number }}</p>
                            <p class="mb-1"><strong>البريد الإلكتروني:</strong> {{ $user->email }}</p>
                            <p class="mb-1"><strong>رقم الجوال:</strong> {{ $user->phone_number }}</p>
                        </div>
                        <div class="col-4 text-center">
                            @if ($user->id_photo_path)
                                <a href="{{ asset('storage/' . $user->id_photo_path) }}" data-glightbox="type:image">
                                    <img src="{{ asset('storage/' . $user->id_photo_path) }}" alt="صورة الهوية" class="img-fluid rounded glightbox" style="width: 100%; height: auto;">
                                </a>
                                <p class="text-muted mt-1" style="font-size: 0.8rem;">اضغط للتكبير</p>
                            @else
                                <span class="text-muted">لا توجد صورة هوية</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card p-4">
                    <h4 class="card-title text-main fw-bold mb-3">المعلومات البنكية</h4>
                    <p class="fw-bold fs-5 py-2 mb-1">{{ $user->bank_name }}</p>
                    <p class="mb-1"><strong>رقم الحساب:</strong> {{ $user->bank_account_number }}</p>
                    <p class="mb-1"><strong>رقم الآيبان:</strong> {{ $user->iban }}</p>

                    <h4 class="card-title text-main fw-bold mt-4 mb-3">الحساب المعتمد للتحصيل</h4>
                    <p class="fw-bold fs-5 py-2 mb-1">بنك الراجحي</p>
                    <p class="mb-1"><strong>رقم الحساب:</strong> 3800010167519</p>
                    <p class="mb-1"><strong>رقم الآيبان:</strong> SA0380000000608010167519</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js"></script>
    <script>
        const lightbox = GLightbox({
            touchNavigation: true,
            loop: false,
            autoplayVideos: false
        });
    </script>
</body>
</html>
