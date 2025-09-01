
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
    <div class="d-flexs" id="wrapper">
        @include('layout.sidebar')

        <div id="page-content-wrapper">
            {{-- @include('layout.header') --}}

            <div class="container py-4">
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h2 class="text-main fw-bold">إضافة مساهمة جديدة</h2>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-main">العودة إلى لوحة التحكم</a>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8 mx-auto">
                        <div class="card shadow border-0 p-4">
                            <form action="{{ route('admin.contributions.store') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label for="user_id" class="form-label">اختر المستخدم:</label>
                                    <select name="user_id" id="user_id" class="form-select" required>
                                        <option value="">اختر من القائمة</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->full_name.' | '.$user->id_number }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="amount" class="form-label">المبلغ (ريال سعودي):</label>
                                    <input type="number" step="0.01" name="amount" id="amount" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label for="transaction_date" class="form-label">تاريخ المساهمة:</label>
                                    <input type="date" name="transaction_date" id="transaction_date" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label for="type" class="form-label">نوع المساهمة:</label>
                                    <select name="type" id="type" class="form-select" required>
                                        <option value="monthly_subscription">اشتراك شهري</option>
                                        <option value="joining_fee">رسوم انضمام</option>
                                        <option value="additional_contribution">مساهمة إضافية</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-main">إضافة المساهمة</button>
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
