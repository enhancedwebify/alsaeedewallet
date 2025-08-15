<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم المسؤول</title>
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
            margin: 0 auto; /* Center the thumbnail */
            display: block; /* Required for margin: 0 auto to work */
            box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24); /* Subtle shadow */
            transition: transform 0.2s ease-in-out;
        }
        .id-photo-thumbnail:hover {
            transform: scale(1.05); /* Slight scale on hover */
        }
    </style>
    <link rel="stylesheet" href="{{asset('css/styles.css')}}">
    @include('layout.head')
</head>
<body>
    <div class="container mt-5">
        @include('layout.header')
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-main">طلبات التسجيل الجديدة</h2>

        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table responsive-table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>الاسم الكامل</th>
                        <th>
                            <div>الهوية الوطنية</div>
                            <div>والمعلومات</div>
                        </th>
                        <th>
                            <div>المعلومات البنكية</div>
                        </th>
                        {{-- <th>رقم الجوال</th> --}}
                        <th>الإجراء</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pendingRequests as $request)
                        <tr>
                            <td data-label="الاسم الكامل">
                                <h3>{{ $request->full_name }}</h3>
                                <div class="pt-3 col-12 col-md-6 py-3 py-md-3">
                                    @if ($request->id_photo_path)
                                        <a href="{{ asset('storage/' . $request->id_photo_path) }}"
                                        data-glightbox="type:image"
                                        data-title="{{ 'صورة هوية: ' . $request->full_name }}">
                                            <img src="{{ asset('storage/' . $request->id_photo_path) }}"
                                                alt="صورة الهوية"
                                                class="id-photo-thumbnail w-100 glightbox" height="100%" >
                                        </a>
                                    @else
                                        <span class="text-muted">لا توجد صورة</span>
                                    @endif
                                </div>
                            </td>
                            <td data-label="الهوية الوطنية والمعلومات">
                                <div>{{ $request->id_number }}</div>
                                <div>{{ $request->email }}</div>
                                <div>{{ $request->phone_number }}</div>


                            </td>
                            <td data-label="المعلومات البنكية">
                                <div>{{ $request->bank_name }}</div>
                                <div>{{ $request->bank_account_number }}</div>
                                <div>{{ $request->iban }}</div>
                            </td>
                            {{-- <td data-label="رقم الجوال"></td> --}}
                            <td data-label="الإجراء">
                                <form action="{{ route('superuser.approve', $request->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-md">الموافقة</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">لا توجد طلبات تسجيل جديدة حاليًا.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
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
