<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>اللائحة المرفقة (صور)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .pdf-page-image {
            width: 100%;
            height: auto;
            border: 1px solid #ddd;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">اللائحة المرفقة</h2>

        {{-- The unnecessary @if block has been removed --}}

        @for ($i = 1; $i <= 9; $i++)
            @php
                $imagePath = '/docs/terms-images/terms-and-conditions-' . $i . '.jpg';
            @endphp

            <div class="pdf-page-container mb-4">
                @if (file_exists(public_path($imagePath)))
                    <img src="{{ asset($imagePath) }}"
                        alt="صفحة {{ $i }}"
                        class="pdf-page-image">
                @else
                    <div class="alert alert-danger text-center">
                        خطأ: لم يتم العثور على صفحة {{ $i }} في المسار {{ $imagePath }}
                    </div>
                @endif
            </div>
        @endfor

        {{-- <div class="text-center mt-3">
            <a href="{{ url()->previous() }}" class="btn btn-primary">العودة</a>
        </div> --}}
    </div>
</body>
</html>
