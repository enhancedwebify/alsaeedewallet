<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>حساب الافراد</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
    <style>
        /* Custom CSS for a better mobile experience */
        @media (max-width: 768px) {
            .table.responsive-table thead {
                display: none; /* Hide the table header on small screens */
            }

            .table.responsive-table tbody tr {
                display: block;
                margin-bottom: 1.5rem;
                border: 1px solid #dee2e6;
                border-radius: .25rem;
                background-color: #fff;
            }

            .table.responsive-table td {
                display: block;
                text-align: right;
                padding-right: 1rem;
                border: none;
                position: relative;
                padding-bottom: 0.5rem;
            }

            /* Add labels to each cell using the data-label attribute */
            .table.responsive-table td::before {
                content: attr(data-label);
                font-weight: bold;
                display: block;
                padding-bottom: 0.25rem;
                color: #6c757d;
                text-align: right;
                border-bottom: 1px solid #e9ecef;
                margin-bottom: 0.5rem;
            }
        }
        /* Custom CSS for a better mobile experience */
        @media (max-width: 768px) {
            /* ... existing mobile responsive styles ... */
        }
        .id-photo-thumbnail {
            width: 80px; /* Slightly smaller for better fit */
            height: auto;
            border-radius: 5px;
            cursor: pointer;
            margin: .5rem 0; /* Center the thumbnail */
            display: block; /* Required for margin: 0 auto to work */
            box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24); /* Subtle shadow */
            transition: transform 0.2s ease-in-out;
        }
        .id-photo-thumbnail:hover {
            transform: scale(1.05); /* Slight scale on hover */
        }
    </style>
    <link rel="stylesheet" href="{{asset('css/styles.css')}}">
</head>
<body>
    <div class="container mt-5">
        @include('layout.header')
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-main">ملف المستفيد</h2>
         {{--   <form action="{{ route('superuser.logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger">تسجيل الخروج</button>
            </form>--}}
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">

        </div>
        <div class="rounded py-3 d-block d-md-flex w-100 px-4 shadow-md border-1 border-main border mb-4">
            <div class="col-12 col-md-6 position-relative">
                <div class="d-flex">

                    <h2 class="fw-bold">{{$requests->full_name }}</h2>
                    @if ($requests->is_approved)
                        <button class="mx-0 mx-md-2 position-absolute m-0 alert alert-info " style="left: 0">تمت الموافقة</button>
                    @else
                        <button class="mx-0 mx-md-2 position-absolute m-0 alert alert-success " style="left: 0">تم التقديم</button>
                    @endif

                </div>
                <div class=" pt-3">
                    <div class="fw-bold text-main">رقم الهوية</div>
                    <div class="fw-bold mb-2 id_numebr">{{$requests->id_number}}</div>
                    <div class="fw-bold text-main">البريد الالكتروني</div>
                    <div class="fw-bold mb-2 bank_iban">{{$requests->email}}</div>
                    <div class="fw-bold text-main">رقم الجوال</div>
                    <div class="fw-bold mb-2 phone_number"><i class="bi bi-home"></i>{{$requests->phone_number}}</div>
                </div>
                <div class="my-3">
                    <h2 class="text-main pb-1">المعلومات البنكية</h2>
                    <div class="fw-bold fs-4 py-2">{{ $requests->bank_name }}</div>
                    <div class="fw-bold text-main">رقم الحساب</div>
                    <div class="fw-bold mb-3">{{ $requests->bank_account_number }}</div>
                    <div class="fw-bold text-main">رقم الآيبان</div>
                    <div class="fw-bold">{{ $requests->iban }}</div>
                </div>
            </div>
            <div class="col-12 col-md-6 py-4 py-md-0">
                @if ($requests->id_photo_path)
                    <a class="" href="{{ asset('storage/' . $requests->id_photo_path) }}"
                    data-glightbox="type:image"
                    data-title="{{ 'صورة هوية: ' . $requests->full_name }}">
                        <img src="{{ asset('storage/' . $requests->id_photo_path) }}"

                            class="rounded glightbox" width="100%" style="object-fit: cover" height="100%">
                    </a>
                @else
                    <span class="text-muted">لا توجد صورة</span>
                @endif
            </div>
        </div>
        <h2 class="text-main my-4 py-3">الحساب المعتمد للتحصيل المالي</h2>
        <div class=" col-12 col-md-4 border-main rounded py-3 px-4 shadow-md border border-1 mb-4">
            <div >
                <h2 class="fs-4 fw-bold py-2">بنك الراجحي</h2>
                <div class="fw-bold text-main">رقم الحساب</div>
                <div class="fw-bold mb-3">3800010167519</div>
                <div class="fw-bold text-main">رقم الآيبان</div>
                <div class="fw-bold">SA0380000000608010167519</div>
            </div>

        </div>
    </div>
    {{-- <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script> --}}
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
