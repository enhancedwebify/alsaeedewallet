 <form id="storeUserForm" action="{{ url('vendor/edit/user', '') }}" method="POST">  {{-- Important: Route will be updated dynamically --}}
    <div class="modal-body">
        @csrf
        @method('POST')  {{-- Important for updates --}}
        <div class="mb-3">
            <input type="hidden" id="edit_user_id" name="user_id" >
            <label for="" class="form-label fw-bold">الاسم</label>
            <input type="text" id="edit_name_ar" name="name_ar" class="form-control form-control-lg my-1" >
        </div>
        <div class="mb-3">
            <label for="" class="form-label fw-bold">رمز الدخول (4 ارقام)</label>
            <input maxlength="4" pattern="\d{4}" inputmode="numeric" required id="edit_pin" name="pin" class="form-control form-control-lg my-1" >
        </div>
        <div class="mb-3">
            <label for="" class="form-label fw-bold">الصلاحية</label>
            <select id="edit_role" name="role" class="form-control form-control-lg my-1" >
                <option value="cashier">كاشير</option>
                <option value="accountant">محاسب</option>
                <option value="manager">مدير عام</option>
                <option value="branch_manager">مدير فرع</option>
                <option value="admin">مسؤول</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="" class="form-label fw-bold">الفرع</label>
            <select id="edit_branch" name="branch_id" class="form-control form-control-lg my-1" >
                @foreach ($vendorBranches as $branch)
                    <option value="{{$branch->id}}">{{$branch->branch_name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
        <button type="submit" class="btn btn-primary">حفظ</button>
    </div>
</form>
