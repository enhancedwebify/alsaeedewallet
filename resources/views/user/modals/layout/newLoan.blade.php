<form action="{{route('user.newLoan')}}" method="POST">
@csrf
<div class="modal-body" >
    <div class="container-fluid  mx-2 px-2">
        <div class="mb-3">
            <label for="iban" class="form-label">رقم الشريحة</label>
            {{-- <input type="text" class="form-control" id="bank_name" name="bank_name" value="{{ old('bank_name') }}" required> --}}
            <select id="loan_tier_id" name="loan_tier_id" class="form-select form-select-lg" value="{{ old('loan_tier_id') }}" required>
                <option value="" disabled selected>اختر  رقم الشريحة</option>

                @foreach ($loan_tiers as $tier)
                    <option value="{{$tier->tier_number}}">شريحة رقم {{$tier->tier_number}} المساهمة {{$tier->contribution_amount}} ريال مدة {{$tier->contribution_period_months}} شهر</option>

                @endforeach

            </select>
            @error('loan_tier_id')
                <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
    <button data-bs-dismiss="modal" class="btn btn-primary cancel_bill" >تقديم</button>
</div>
</form>
