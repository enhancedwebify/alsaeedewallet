@extends('layout.app')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>تعديل العضو: {{ $user->name }}</h2>
        <a href="{{ route('admin.users.index') }}" class="btn btn-primary">العودة إلى الأعضاء</a>
    </div>
    <hr>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">الاسم الكامل</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->full_name) }}" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">البريد الإلكتروني</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                </div>

                <button type="submit" class="btn btn-primary mt-3">حفظ التغييرات</button>
            </form>
        </div>
    </div>
</div>
@endsection
