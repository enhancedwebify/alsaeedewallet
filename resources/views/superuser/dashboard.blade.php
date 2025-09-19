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
        /* .text-main {
            color: #551d7c;
        } */
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
    {{-- This is the main container for the dashboard. It will house the sidebar and the content. --}}
    @include('layout.sidebar_superuser')
    <div class="container mt-2">

        {{-- The Admin Sidebar --}}
        {{-- You may need to create a separate sidebar file for admin navigation links --}}

        <div id="page-content-wrapper">
            {{-- The top header/navbar --}}
            {{-- @include('layout.header') --}}

            {{-- The main content of the dashboard --}}
            <div class="container-fluid py-4">
                <div class="row">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="text-main fw-bold">لوحة تحكم الإدارة</h2>
                    </div>
                </div>
                <div class="container mt-3">
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

                        <div class="col-md-4">
                            <div class="card text-center bg-main-light text-main">
                                <div class="card-body">
                                    <h5 class="card-title">طلبات الموافقة</h5>
                                    <p class="card-text fs-2">{{ $pending_requests }}</p>
                                    <p class="card-text">طلب</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card text-center bg-main-light text-main">
                                <div class="card-body">
                                    <h5 class="card-title">إجمالي المستخدمين</h5>
                                    <p class="card-text fs-2">{{ $total_users }}</p>
                                    <p class="card-text">مستخدم</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row mt-5">
                    <div class="col-12">
                        <div class="card shadow border-0">
                            <div class="card-header p-4 bg-transparent border-0 d-flex justify-content-between align-items-center">
                                <h3 class="mb-0 text-main fw-bold">طلبات الموافقة الأخيرة</h3>
                                <a href="#" class="btn btn-sm btn-primary">عرض الكل</a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover align-items-center table-flush">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col" class="text-uppercase text-secondary">اسم المستخدم</th>
                                            <th scope="col" class="text-uppercase text-secondary">النوع</th>
                                            <th scope="col" class="text-uppercase text-secondary">تاريخ الطلب</th>
                                            <th scope="col" class="text-uppercase text-secondary">الحالة</th>
                                            <th scope="col" class="text-uppercase text-secondary">الإجراء</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list">
                                        {{-- Placeholder for a loop through your pending requests --}}
                                        @forelse ($pendingApprovals as $request)
                                        <tr>
                                            <td>
                                                {{ $request->user->full_name }}
                                            </td>
                                            <td>{{ str_replace(
                                                    ['contribution','loan_request','tier_change_request'],
                                                    ['مساهمة','طلب قرض','طلب تغيير شريحة مساهمة'],
                                                    $request->type) }}</td>
                                            <td>{{ $request->created_at->format('Y-m-d') }}</td>
                                            <td><span class="badge bg-warning text-dark">{{ str_replace(
                                                    ['pending','approved'],
                                                    ['انتظار','مقبول'],
                                                    $request->status) }}</span></td>
                                            <td>
                                                <a href="{{ route('admin.approvals.show', $request->id) }}"  class="btn btn-sm btn-primary">عرض التفاصيل</a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center">لا توجد طلبات معلقة حاليًا.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-12">
                        <div class="card shadow border-0">
                            <div class="card-header p-4 bg-transparent border-0 d-flex justify-content-between align-items-center">
                                <h3 class="mb-0 fw-bold">آخر المساهمات المضافة</h3>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover align-items-center table-flush">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col" class="text-uppercase text-secondary">اسم المستخدم</th>
                                            <th scope="col" class="text-uppercase text-secondary">المبلغ (ريال)</th>
                                            <th scope="col" class="text-uppercase text-secondary">النوع</th>
                                            <th scope="col" class="text-uppercase text-secondary">تاريخ المساهمة</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list">
                                        @forelse ($latestContributions as $contribution)
                                        <tr>
                                            <td>{{ $contribution->user?->full_name }}</td>
                                            <td>{{ number_format($contribution->amount, 2) }}</td>
                                            <td>
                                                @if ($contribution->type == 'monthly_subscription')
                                                    اشتراك شهري
                                                @elseif ($contribution->type == 'joining_fee')
                                                    رسوم انضمام
                                                @elseif ($contribution->type == 'additional_contribution')
                                                    مساهمة إضافية
                                                @elseif ($contribution->type == 'contribution')
                                                    مساهمة شهرية
                                                @elseif ($contribution->type == 'loan_request')
                                                    طلب قرض
                                                @endif
                                            </td>
                                            <td>{{ $contribution->transaction_date }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center">لا توجد مساهمات مسجلة حتى الآن.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- The footer and closing scripts --}}
    @include('layout.scripts')
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js"></script> --}}

</body>

</html>
