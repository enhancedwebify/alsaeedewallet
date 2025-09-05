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
    @include('layout.head')
</head>
<body>
    @include('layout.sidebar')
    <div class="container mt-5">
        {{-- @include('layout.header') --}}
        <!-- Modal Pos Opt. -->
        @include('user.modals.modal',[
            'modal_id' => 'newLoan',
            'modal_title' => 'قرض جديد',
            'modal_body' => 'newLoan',
            'modal_parameters' => []

        ])
        @if (session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger text-center">{{ session('error') }}</div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-main fw-bold">لوحة التحكم</h2>
        </div>
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card shadow border-0 p-4 text-center">
                    <h5 class="card-title fw-bold text-muted ">إجمالي المساهمات</h5>
                    <h2 class="card-text fw-bold text-main">{{ number_format($total_contributions ?? 0, 2) }} ريال</h2>
                    <p class="text-muted">آخر تحديث: اليوم</p>
                </div>
            </div>
            {{-- <div class="col-md-4">
                <div class="card shadow border-0 p-4 text-center">
                    <h5 class="card-title fw-bold">الرصيد المتاح للقرض</h5>
                    <h2 class="card-text fw-bold">{{ number_format($available_loan_balance ?? 0, 2) }} ريال</h2>
                    <p class="text-muted">مبلغ قرضك الحالي</p>
                </div>
            </div> --}}
            <div class="col-md-4">
                <div class="card shadow border-0 p-4 text-center">
                    <h5 class="card-title fw-bold text-muted ">قسط الشهر القادم</h5>
                    <h2 class="card-text fw-bold text-main">{{ number_format($next_payment_amount ?? 0, 2) }} ريال</h2>
                    <p class="text-muted">تاريخ الاستحقاق: 15 أغسطس</p>
                </div>
            </div>
             <div class="col-md-4">
                <div class="card card-stats shadow border-0 p-4 text-center">
                    {{-- <div class="card-body">
                        <div class="rows">
                            <div class="colss"> --}}
                                <h5 class="card-title fw-bold text-uppercase text-muted ">القيمة القصوى للقرض</h5>
                                <h2 class="card-text fw-bold text-main font-weight-bold ">
                                    {{ number_format($available_loan_amount, 2) }} ريال
                                </h2>
                                <p class="text-muted">تاريخ الاستحقاق: 15 أغسطس</p>
                            {{-- </div>
                        </div>
                    </div> --}}
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-stats shadow border-0 p-4 text-center">
                    @if ($isLoanEligible)
                        <h5 class="fw-bold text-main mb-3">أنت مؤهل لتقديم طلب قرض.</h5>
                        <p>يمكنك الآن تقديم طلب قرض جديد من خلال الزر أدناه.</p>
                        <a href="{{ route('user.loans.request') }}" class="btn btn-lg btn-primary">
                            تقديم طلب قرض
                        </a>
                    @else
                        <h5 class="fw-bold text-muted mb-3">أنت غير مؤهل حاليًا لتقديم طلب قرض.</h5>
                        <p class="text-muted">
                            تتطلب اللائحة أن يكون العضو قد أتم سنة كاملة من المساهمات الشهرية.
                            <br>
                            متبقي لك {{ 12 - $user->contributions()->where('type', 'contributions')->count() }} شهر حتى تصبح مؤهلاً.
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <div class="row mb-4 mx-1">
            <div class="card card-custom shadow border-0  p-0 h-100 d-flex flex-column justify-content-center">
                <div class="d-flexs justify-content-around m-0 p-0 flex-wraps " style="height: 100%;display: table;">
                    {{-- <a href="#" class="btn btn-lg btn-primary fw-bold m-2 w-100"  >
                        <i class="bi bi-wallet2"></i> إيداع مساهمة جديدة
                    </a> --}}
                    @php
                        // Get the latest approval record for this user
                        $latestApproval = $user->approvals()->latest()->first();
                        $hide = '';
                        // Now you can check if a record was found and access its properties
                        if ($latestApproval) {
                            if($latestApproval->status)
                                $hide = 'disabled';
                        } else {
                            echo "No approval found for this user.";
                        }
                    @endphp
                    {{-- @if ($pending_for_approval>0)

                        <a href="#" {{$hide}} class="text-center text-decoration-none alert alert-info fw-bold  w-100" style="height:100%; display: table-cell;vertical-align:middle" >
                            <i class="bi bi-cash-stack"></i>  تم تقديم طلب تغيير شريحة المساهمة
                        </a>
                    @else
                    @endif --}}
                    <a href="#" {{$hide}} class="btn btn-lg btn-primary fw-normal  w-100" style="height:100%; display: table-cell;"  data-bs-toggle="modal" data-bs-target="#newLoan" >
                        <i class="bi bi-cash-stack"></i>  طلب تغيير شريحة المساهمة
                    </a>
                </div>
            </div>
        </div>
        <div class="row mb-4">

            <div class="col-md-4 mb-3">
                <div class="card shadow border-0  p-4 h-100">
                    <h5 class="fw-bold">حالة الطلب</h5>
                    @php
                        $lastRow = null; // Initialize a variable to store the last row

                        // Loop through the data
                        foreach ($user->approvals as $row) {
                            // In a real database scenario, this would be:
                            // while ($row = mysqli_fetch_assoc($result)) {

                            // Store the current row in $lastRow in each iteration
                            $lastRow = $row;
                        }
                        // echo $lastRow;
                    @endphp
                    @if (isset($user->approvals))

                        {{-- @dump(($user->approvals->last())) --}}
                        @foreach ($user->approvals as $approval)
                            @if ($lastRow !== null)
                                <div class="fw-bold py-2"><span class="fw-bold">الشريحة رقم: </span><span>{{$approval->loanTier->tier_number}} المساهمة {{$approval->loanTier->contribution_amount}} ريال مدة {{$approval->loanTier->contribution_period_months}} شهر</span></div>
                                @if ($approval->status =='approved')
                                        <span class="badge bg-main text-white py-2 px-3 fw-normal fs-6">نشط</span>
                                @elseif($approval->status =='rejected')
                                    <span class="badge alert alert-danger text-dark py-2 px-3 fw-normal fs-6">{{$approval->notes}}</span>
                                @else
                                <span class="badge bg-warning text-dark py-2 px-3 fw-normal fs-6">طلبك قيد المراجعة</span>
                                <p class="text-muted mt-2 mb-0">نحن نعمل على مراجعة طلبك وإعلامك بالنتيجة قريباً.</p>
                                @endif
                            @endif

                        @endforeach
                    @endif
                </div>
            </div>
            <div class="col-md-4 mb-3" hidden>
                <div class="card shadow border-0  p-4s h-100 d-flex flex-column justify-content-center">
                    <div class="d-flexs justify-content-around m-0 p-0 flex-wraps " style="height: 100%;display: table;">
                        {{-- <a href="#" class="btn btn-lg btn-primary fw-bold m-2 w-100"  >
                            <i class="bi bi-wallet2"></i> إيداع مساهمة جديدة
                        </a> --}}
                        @php
                          // Get the latest approval record for this user
                            $latestApproval = $user->approvals()->latest()->first();
                            $hide = '';
                            // Now you can check if a record was found and access its properties
                            if ($latestApproval) {
                                if($latestApproval->status)
                                    $hide = 'disabled';
                            } else {
                                echo "No approval found for this user.";
                            }
                        @endphp
                        @if ($pending_for_approval>0)

                            <a href="#" {{$hide}} class="text-center text-decoration-none alert alert-info fw-bold  w-100" style="height:100%; display: table-cell;vertical-align:middle" >
                                <i class="bi bi-cash-stack"></i>  تم تقديم طلب تغيير شريحة المساهمة
                            </a>
                        @else
                            <a href="#" {{$hide}} class="btn btn-lg btn-primary fw-bold  w-100" style="height:100%; display: table-cell;"  data-bs-toggle="modal" data-bs-target="#newLoan" >
                                <i class="bi bi-cash-stack"></i>  طلب تغيير شريحة المساهمة
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card shadow border-0  p-4 h-100">
                    <h5 class="fw-bold">قروض</h5>
                     @if ($isLoanEligible)
                            <h5 class="fw-bolds text-main mb-3">أنت مؤهل لتقديم طلب قرض.</h5>
                            <p>يمكنك الآن تقديم طلب قرض جديد من خلال الزر أدناه.</p>
                            <a href="{{ route('user.loans.request') }}" class="btn btn-lg btn-primary">
                                تقديم طلب قرض
                            </a>

                            {{-- IF has loan then will work on this button --}}
                            <a href="#" class="btn btn-lg btn-outline-primary my-2 w-100">
                                <i class="bi bi-arrow-right-circle"></i> سداد قسط
                            </a>
                        @else
                            <h5 class="fw-bold text-muted mb-3">أنت غير مؤهل حاليًا لتقديم طلب قرض.</h5>
                            <p>
                                تتطلب اللائحة أن يكون العضو قد أتم سنة كاملة من المساهمات الشهرية.
                                <br>
                                متبقي لك {{ 12 - $user->contributions()->where('type', 'monthly_subscription')->count() }} شهر حتى تصبح مؤهلاً.
                            </p>
                        @endif
                             {{-- <a href="{{ route('user.loans.request') }}" class="btn btn-lg btn-success">
                                تقديم طلب قرض
                            </a> --}}
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card shadow border-0  p-4">
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
                <div class="card shadow border-0  p-4">
                    <h4 class="card-title text-main fw-bold mb-3">المعلومات البنكية</h4>
                    <p class="fw-bold fs-5 py-2 mb-1">{{ $user->bank_name }}</p>
                    <p class="mb-1"><strong>رقم الحساب:</strong> {{ $user->bank_account_number }}</p>
                    <p class="mb-1"><strong>رقم الآيبان:</strong> {{ $user->iban }}</p>
                    <hr class="text-main">
                    <h4 class="card-title text-main fw-bold  mb-3">الحساب المعتمد للتحصيل</h4>
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
