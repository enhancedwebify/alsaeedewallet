<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل عضو جديد</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44u2z8yQ4fH9tQ4N3eA1e5l91986c57q0sH49Q1n72x8m152z915yW7M7Q1D9b5s77v0g==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
    <link rel="stylesheet" href="{{asset('css/sstyles.css')}}" type="text/css">

</head>
<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 register-container">
                <div class="pinTL"></div>
                <div class="pinTR"></div>
                <div class="pinBL"></div>
                <div class="pinBR"></div>
                <h2 class="text-center mb-4">تسجيل عضو جديد</h2>

                <form method="POST" id="myForm" action="{{ url('register') }}" enctype="multipart/form-data">
                    @csrf <div class="mb-3">
                        <label for="full_name" class="form-label">الاسم الكامل</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" value="{{ old('full_name') }}" required autofocus>
                        @error('full_name')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="id_number" class="form-label">السجل المدني</label>
                        <input type="text" class="form-control" id="id_number" name="id_number" value="{{ old('id_number') }}" required>
                        @error('id_number')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone_number" class="form-label">رقم الجوال</label>
                        <input type="tel" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required>
                        @error('phone_number')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">البريد الإلكتروني</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="iban" class="form-label">اسم البنك</label>
                        {{-- <input type="text" class="form-control" id="bank_name" name="bank_name" value="{{ old('bank_name') }}" required> --}}
                        <select id="loan_tier_id" name="loan_tier_id" class="form-select" value="{{ old('loan_tier_id') }}" required>
                            <option value="" disabled selected>اختر  رقم الشريحة</option>

                            @foreach ($loan_tiers as $tier)
                                <option value="{{$tier->tier_number}}">شريحة رقم {{$tier->tier_number}} المساهمة {{$tier->contribution_amount}} ريال مدة {{$tier->contribution_period_months}} شهر</option>

                            @endforeach

                        </select>
                        @error('loan_tier_id')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="iban" class="form-label">اسم البنك</label>
                        {{-- <input type="text" class="form-control" id="bank_name" name="bank_name" value="{{ old('bank_name') }}" required> --}}
                        <select id="bank_name" name="bank_name" class="form-select" value="{{ old('bank_name') }}" required>
                            <option value="" disabled selected>اختر البنك</option>
                            <option value="البنك الأهلي السعودي">البنك الأهلي السعودي</option>
                            <option value="مصرف الراجحي">مصرف الراجحي</option>
                            <option value="بنك الرياض">بنك الرياض</option>
                            <option value="بنك البلاد">بنك البلاد</option>
                            <option value="البنك السعودي الفرنسي">البنك السعودي الفرنسي</option>
                            <option value="بنك الجزيرة">بنك الجزيرة</option>
                            <option value="البنك العربي الوطني">البنك العربي الوطني</option>
                            <option value="البنك السعودي البريطاني (ساب)">البنك السعودي البريطاني (ساب)</option>
                            <option value="مصرف الإنماء">مصرف الإنماء</option>
                            <option value="بنك الجزيرة">بنك الجزيرة</option>
                            <option value="بنك الخليج الدولي">بنك الخليج الدولي</option>
                            <option value="مجموعة سامبا المالية">مجموعة سامبا المالية</option>
                        </select>
                        @error('bank_name')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="iban" class="form-label">رقم الحساب</label>
                        <input type="text" class="form-control" id="bank_account_number" name="bank_account_number" value="{{ old('bank_account_number') }}" required>
                        @error('bank_account_number')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="iban" class="form-label">رقم IBAN</label>
                        <input type="text" class="form-control" id="iban" name="iban" value="{{ old('iban') }}" required>
                        @error('iban')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="id_photo" class="form-label">صورة من الأحوال (صورة الهوية الوطنية)</label>
                        <input type="file" class="form-control" id="id_photo" name="id_photo" required>
                        @error('id_photo')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">كلمة المرور</label>
                        <input type="password" class="form-control" id="password" name="password" required autocomplete="new-password">
                        @error('password')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">تأكيد كلمة المرور</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="terms_correct" name="terms_correct" required>
                        <label class="form-check-label" for="terms_correct">
                            أقر أن جميع البيانات المدخلة صحيحة.
                        </label>
                        @error('terms_correct')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="terms_agreed" name="terms_agreed" required>
                        <label class="form-check-label" for="terms_agreed">
                            أوافق على <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal" class="btn btn-primary">اللائحة المرفقة</a>.
                        </label>
                        @error('terms_agreed')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div> --}}
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="terms_agreed" name="terms_agreed" disabled>
                        <label class="form-check-label" for="terms_agreed">
                            <span>أوافق على الشروط والأحكام.</span>
                        </label>
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#termsModal">اللائحة المرفقة</a>.
                         @error('terms_agreed')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>


                    <button type="submit" id="submitForm" class="btn btn-primary w-100" disabled onclick="this.preventDefault()">تسجيل</button>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <h5 class="modal-title" id="termsModalLabel">اللائحة المرفقة</h5>
                </div>
                <div class="modal-body p-0">
                    <iframe src="{{ route('terms.images') }}" style="width:100%; height:80vh; border:none;"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="agreeAndCloseBtn">أوافق وأغلق</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const agreeBtn = document.getElementById('agreeAndCloseBtn');
            const termsCheckbox = document.getElementById('terms_agreed');
            const submitForm = document.getElementById('submitForm');
            const termsModal = new bootstrap.Modal(document.getElementById('termsModal'));
            termsCheckbox.addEventListener('click', function () {

                if(termsCheckbox.checked==false){
                    submitForm.disabled = true;
                }else{
                    submitForm.disabled = false;
                }
            });
            agreeBtn.addEventListener('click', function () {
                // Enable the checkbox
                termsCheckbox.disabled = false;
                // Check the checkbox
                termsCheckbox.checked = true;
                // Close the modal
                termsModal.hide();
                submitForm.disabled = false;
            });
            form.addEventListener('submit', function (event) {
            // Check if the checkbox is not checked
            if (!termsCheckbox.checked) {
                // Prevent the form from submitting
                event.preventDefault();
                // Show an alert to the user
                alert('الرجاء الموافقة على الشروط والأحكام للمتابعة.');
                // Or display an error message next to the checkbox
                // const errorDiv = document.createElement('div');
                // errorDiv.className = 'text-danger mt-2';
                // errorDiv.textContent = 'يجب عليك الموافقة على الشروط.';
                // termsCheckbox.parentNode.appendChild(errorDiv);
            }
        });
        });
    </script>
</body>
</html>
