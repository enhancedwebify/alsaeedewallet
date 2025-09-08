<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"  >
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <style>
        /* Custom primary color */
            :root {
            --main-color: #2c3e50; /* A dark, professional color */
            }

            .text-main {
            color: var(--main-color) !important;
            }

            .btn-main {
            background-color: var(--main-color);
            color: #fff;
            border-color: var(--main-color);
            }

            .btn-main:hover {
            background-color: #34495e;
            border-color: #34495e;
            }

            /* Styles for the dashboard icons */
            .icon-shape {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            vertical-align: middle;
            width: 4rem;
            height: 4rem;
            border-radius: 50%;
            font-size: 1.5rem;
            background-color: var(--main-color); /* Matches the main color */
            }

            .card-stats {
            border-radius: 0.5rem;
            transition: transform 0.2s ease-in-out;
            }

            .card-stats:hover {
            transform: translateY(-5px);
            }
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
    @include('layout.sidebar_superuser')
    <div class="container mt-5">

        <div id="page-content-wrapper">
            {{-- @include('layout.header') --}}

            <div class="container py-4">
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h2 class="text-main fw-bold">تفاصيل طلب الموافقة</h2>
                            <a href="{{ route('superuser.dashboard') }}" class="btn btn-sm btn-primary">العودة إلى لوحة التحكم</a>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card shadow border-0 p-4">
                            <h5 class="fw-bold text-main mb-3">معلومات المستخدم</h5>
                            <div class="d-flex flex-column gap-2">
                                <div><strong>الاسم الكامل:</strong> {{ $approval->user->full_name }}</div>
                                <div><strong>رقم الهوية:</strong> {{ $approval->user->id_number }}</div>
                                <div><strong>البريد الإلكتروني:</strong> {{ $approval->user->email }}</div>
                                <div><strong>رقم الجوال:</strong> {{ $approval->user->phone_number }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card shadow border-0 p-4">
                            <h5 class="fw-bold text-main mb-3">المعلومات البنكية</h5>
                            <div class="d-flex flex-column gap-2">
                                <div><strong>اسم البنك:</strong> {{ $approval->user->bank_name }}</div>
                                <div><strong>رقم الحساب:</strong> {{ $approval->user->bank_account_number }}</div>
                                <div><strong>رقم الأيبان:</strong> {{ $approval->user->iban }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12 mb-4">
                        <div class="card shadow border-0 p-4">
                            <h5 class="fw-bold text-main mb-3">صورة الهوية</h5>
                            @if ($approval->user->id_photo_path)
                            <a href="{{ asset('storage/' . $approval->user->id_photo_path) }}" data-glightbox="type:image" data-title="صورة هوية: {{ $approval->user->full_name }}">
                                <img src="{{ asset('storage/' . $approval->user->id_photo_path) }}" class="img-fluids glightbox rounded shadow-sm" height="220px" alt="صورة الهوية">
                            </a>
                            @else
                            <div class="text-muted">لا توجد صورة هوية مرفوعة.</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card shadow border-0 p-4">
                            <h5 class="fw-bold text-main mb-3">إدارة طلب الموافقة</h5>
                            <form action="{{ route('admin.approvals.process', $approval->id) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="loan_tier_id" class="form-label">الشريحة المختارة:</label>

                                    <select name="loan_tier_id" id="loan_tier_id" class="form-select" required>
                                        <option value="">اختر فئة</option>
                                        @foreach ($loanTiers as $tier)
                                            @if($approval->loan_tier_id == $tier->tier_number)
                                            {{-- <option value="{{ $tier->id }}">{{ 'الفئة ' . $tier->tier_number }}</option> --}}
                                            <option selected value="{{$tier->tier_number}}">شريحة رقم {{$tier->tier_number}} المساهمة {{$tier->contribution_amount}} ريال مدة {{$tier->contribution_period_months}} شهر</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="notes" class="form-label">ملاحظات (اختياري):</label>
                                    <textarea name="notes" id="notes" class="form-control" rows="3"></textarea>
                                </div>
                                <div class="d-flex gap-2">
                                    <button type="submit" name="action" value="approve" class="btn btn-success">الموافقة على الطلب</button>
                                    <button type="submit" name="action" value="reject" class="btn btn-danger">رفض الطلب</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layout.scripts')
</body>
</html>
