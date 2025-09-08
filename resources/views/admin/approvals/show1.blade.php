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

    <div class="d-grid  col-12 col-md-8" id="wrapper">
        @include('layout.sidebar')

        <div id="page-content-wrapper" >
            {{-- @include('layout.header') --}}

            <div class="container py-4 ">
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h2 class="text-main fw-bold">تفاصيل طلب الموافقة</h2>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-primary">العودة إلى لوحة التحكم</a>
                        </div>
                    </div>
                </div>
                @if (session('error'))
                    <div class="alert alert-danger text-center">{{ session('error') }}</div>
                @endif

                @if ($approval->status == 'pending')
                    <div class="alert alert-warning text-center">
                        هذا الطلب في حالة انتظار المراجعة.
                    </div>
                @elseif ($approval->status == 'approved')
                    <div class="alert alert-success text-center">
                        تمت الموافقة على هذا الطلب.
                    </div>
                @else
                    <div class="alert alert-danger text-center">
                        تم رفض هذا الطلب.
                    </div>
                @endif

                <div class="card shadow border-0 p-4 mb-4">
                    <h5 class="fw-bold mb-3">تفاصيل الطلب</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>اسم المستخدم:</strong>
                            <span>{{ $approval->user->full_name }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>نوع الطلب:</strong>
                            <span>
                                @if ($approval->type == 'loan_request')
                                    طلب قرض
                                @elseif ($approval->type == 'tier_change_request')
                                    طلب تغيير شريحة
                                @elseif ($approval->type == 'contribution')
                                    مساهمة
                                @endif
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>تاريخ الطلب:</strong>
                            <span>{{ $approval->created_at->format('Y-m-d') }}</span>
                        </li>
                    </ul>
                </div>

                {{-- Loan Request Details --}}
                @if ($approval->type == 'loan_request')
                    <div class="card shadow border-0 p-4 mb-4">
                        <h5 class="fw-bold mb-3">تفاصيل القرض المطلوب</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>شريحة القرض:</strong>
                                <span>{{ $approval->loanTier->tier_number }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>مبلغ القرض:</strong>
                                <span>{{ number_format($approval->loanTier->loan_amount_min) }} - {{ number_format($approval->loanTier->loan_amount_max) }} ريال</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>القسط الشهري:</strong>
                                <span>{{ number_format($approval->loanTier->monthly_installment, 2) }} ريال</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>الملاحظات:</strong>
                                <span>{{ $approval->notes ?? 'لا توجد ملاحظات.' }}</span>
                            </li>
                        </ul>
                    </div>

                    {{-- Admin Action Form --}}
                    @if ($approval->status == 'pending')
                        <div class="card shadow border-0 p-4">
                            <h5 class="fw-bold mb-3">الإجراءات</h5>
                            <form action="{{ route('admin.approvals.process', $approval->id) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="action" class="form-label">القرار:</label>
                                    <select name="action" id="action" class="form-select" required>
                                        <option value="approve">موافقة</option>
                                        <option value="reject">رفض</option>
                                    </select>
                                </div>
                                {{-- Conditional Guarantor Field --}}
                                @if ($isGuarantorRequired)
                                    <div class="mb-3" id="guarantor-field">
                                        <label for="guarantor_id" class="form-label">اختر الكفيل:</label>
                                        <select name="guarantor_id" id="guarantor_id" class="form-select" required>
                                            <option value="">اختر من القائمة</option>
                                            @foreach ($allUsers as $guarantor)
                                                {{-- Exclude the current user from the list of guarantors --}}
                                                @if ($guarantor->id != $approval->user->id && $guarantor->is_admin != 1)
                                                    <option value="{{ $guarantor->id }}">{{ $guarantor->full_name }} | {{ $guarantor->id_number }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                @else
                                    <div class="alert alert-info" id="guarantor-info">
                                        لا يتطلب هذا القرض وجود كفيل.
                                    </div>
                                @endif
                                <button type="submit" class="btn btn-primary">تأكيد القرار</button>
                            </form>
                        </div>
                    @endif
                @endif

                {{-- Tier Change Request Details --}}
                @if ($approval->type == 'tier_change_request')
                    <div class="card shadow border-0 p-4 mb-4">
                        <h5 class="fw-bold mb-3">تفاصيل طلب تغيير الشريحة</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>الشريحة الحالية:</strong>
                                <span>{{ ($current_tier->loan_tier_id!=null)? $current_tier->loan_tier_id:'' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>الشريحة المطلوبة:</strong>
                                <span>{{ $approval->loanTier->tier_number }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>المساهمة الشهرية الجديدة:</strong>
                                <span>{{ number_format($approval->loanTier->monthly_installment, 2) }} ريال</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>الملاحظات:</strong>
                                <span>{{ $approval->notes ?? 'لا توجد ملاحظات.' }}</span>
                            </li>
                        </ul>
                    </div>
                    {{-- Admin Action Form for Tier Change --}}
                    @if ($approval->status == 'pending')
                    <div class="card shadow border-0 p-4">
                        <h5 class="fw-bold mb-3">الإجراءات</h5>
                        <form action="{{ route('admin.approvals.process', $approval->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="notes" class="form-label">ملاحظات (اختياري):</label>
                                <textarea name="notes" id="notes" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="action" class="form-label">القرار:</label>
                                <select name="action" id="action" class="form-select" required>
                                    <option value="approve">موافقة</option>
                                    <option value="reject">رفض</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">تأكيد القرار</button>
                        </form>
                    </div>
                    @endif
                @endif

                {{-- New Contributor Details --}}
                @if ($approval->type == 'contribution')
                    <div class="card shadow border-0 p-4 mb-4">
                        <h5 class="fw-bold mb-3">تفاصيل الطلب </h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>الشريحة المطلوبة:</strong>
                                <span>{{ $approval->loanTier->tier_number }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>المساهمة الشهرية:</strong>
                                <span>{{ number_format($approval->loanTier->monthly_installment, 2) }} ريال</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>الملاحظات:</strong>
                                <span>{{ $approval->notes ?? 'لا توجد ملاحظات.' }}</span>
                            </li>
                        </ul>
                    </div>
                    {{-- Admin Action Form for Tier Change --}}
                    @if ($approval->status == 'pending')
                    <div class="card shadow border-0 p-4">
                        <h5 class="fw-bold mb-3">الإجراءات</h5>
                        <form action="{{ route('admin.approvals.process', $approval->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="notes" class="form-label">ملاحظات (اختياري):</label>
                                <textarea name="notes" id="notes" class="form-control" rows="3"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="action" class="form-label">القرار:</label>
                                <select name="action" id="action" class="form-select" required>
                                    <option value="approve">موافقة</option>
                                    <option value="reject">رفض</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">تأكيد القرار</button>
                        </form>
                    </div>
                    @endif
                @endif

            </div>
        </div>
    </div>
    {{-- @include('layout.footer') --}}
</body>
</html>
