<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>اللائحة المرفقة</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="{{asset('css/styles.css')}}">
</head>
<body>

    <div class="container mt-5">
        <h2 class="text-center mb-4">اللائحة المرفقة</h2>
        <div class="pdf-viewer" style="border: 1px solid #ccc;">
            <object data="{{ route('terms.show') }}" type="application/pdf" width="100%" height="600">
                <iframe src="{{ route('terms.show') }}" style="width:100%; height:80vh; border:none;"></iframe>
            </object>
        </div>
        <div class="text-center mt-3">
            <a href="{{ url()->previous() }}" class="btn btn-primary">العودة</a>
        </div>
    </div>
</body>
</html>
