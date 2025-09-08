@extends('layout.app')

@section('content')
<div class="container mt-3">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>إضافة عضو جديد</h2>
        <a href="{{ route('admin.users.index') }}" class="btn btn-primary">العودة إلى الأعضاء</a>
    </div>
    <hr>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">الاسم الكامل</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">البريد الإلكتروني</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">كلمة المرور</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="is_admin" name="is_admin" value="1" {{ old('is_admin') ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_admin">منحه صلاحيات المدير</label>
                </div>

                <button type="submit" class="btn btn-primary mt-3">إضافة العضو</button>
            </form>
        </div>
    </div>
</div>
@endsection
