@extends('layout.app')

@section('content')
<div class="container mt-3">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>إدارة الأعضاء</h2>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">إضافة عضو جديد</a>
    </div>
    <hr>

    @if ($users->count() > 0)
        <table class="table table-striped table-bordered">
            <thead class="bg-light">
                <tr>
                    <th>الاسم</th>
                    <th>البريد الإلكتروني</th>
                    <th>الحالة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>
                            <div>{{ $user->full_name }}</div>
                            <div>{{ $user->id_number }}</div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if ($user->is_admin==1)
                                <span class="badge bg-primary">مدير</span>
                            @else
                                <span class="badge bg-secondary">عضو</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-primary text-white">عرض</a>
                            <a href="#" class="btn btn-sm btn-dark text-white">تعديل</a>
                            <a href="#" class="btn btn-sm btn-danger text-white">حذف</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-warning text-center">
            لا يوجد أعضاء مسجلين حالياً.
        </div>
    @endif
</div>
@endsection
