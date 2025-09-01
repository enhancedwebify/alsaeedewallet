<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مساهماتي</title>
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
                            <h2 class="text-main fw-bold">سجل المساهمات</h2>
                            <a href="{{ route('user.dashboard') }}" class="btn btn-sm btn-main">العودة إلى لوحة التحكم</a>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card shadow border-0 p-4">
                            <div class="table-responsive">
                                <table class="table table-hover align-items-center table-flush">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col" class="text-uppercase text-secondary">المبلغ (ريال)</th>
                                            <th scope="col" class="text-uppercase text-secondary">النوع</th>
                                            <th scope="col" class="text-uppercase text-secondary">تاريخ المساهمة</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list">
                                        @forelse ($contributions as $contribution)
                                        <tr>
                                            <td>{{ number_format($contribution->amount, 2) }}</td>
                                            <td>
                                                @if ($contribution->type == 'monthly_subscription')
                                                    اشتراك شهري
                                                @elseif ($contribution->type == 'joining_fee')
                                                    رسوم انضمام
                                                @elseif ($contribution->type == 'additional_contribution')
                                                    مساهمة إضافية
                                                @endif
                                            </td>
                                            <td>{{ $contribution->transaction_date }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="3" class="text-center">لا توجد مساهمات مسجلة حتى الآن.</td>
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
    {{-- @include('layout.footer') --}}
</body>
</html>
