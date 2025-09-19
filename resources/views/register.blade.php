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
    @include('layout.head')
</head>
<body>

    <div id="container" class="m-auto py-3 bg-  px-2 noto-sans-arabic position-relative">
        <header class="h-100">
           <!-- place navbar here -->
            <div class="d-flex position-relative" style="z-index: 1;">

                <div class="logo w-50 mx-auto text-end">
                    <img src="{{asset('img/familyewallet.png')}}" height="70">

                </div>
                <div class="position-absolutes w-100 pt-5 d-flex justify-content-center" style="z-index: -1;top: 100px;">
                    <div class="liquid_shape justify-content-center text-white" style="  display: flex;align-items: center;"> <div class="fw-bold h1 text-center">تسجيل عضو جديد</div></div>
                </div>
                <div class="btns w-50 mx-auto text-start">
                    <a href="{{url('/')}}" class="btn btn-primary">رجوع <i class="bi bi-arrow-left"></i></a>
                </div>
            </div>
       </header>
       <main class="pt-2 pb-3">
        <div class="title  pt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 register-container">
                <div class="pinTL"></div>
                <div class="pinTR"></div>
                <div class="pinBL"></div>
                <div class="pinBR"></div>
                {{-- <h2 class="text-center mb-4">تسجيل عضو جديد</h2> --}}

                <form method="POST" id="myForm" action="{{ url('register') }}" enctype="multipart/form-data">
                    @csrf <div class="mb-3">
                        <label for="full_name" class="form-label">الاسم الكامل</label>
                        <input type="text" class="form-control form-control-lg" id="full_name" name="full_name" value="{{ old('full_name') }}" required autofocus>
                        @error('full_name')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="id_number" class="form-label">السجل المدني</label>
                        <input type="text" class="form-control form-control-lg" id="id_number" name="id_number" value="{{ old('id_number') }}" required>
                        @error('id_number')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone_number" class="form-label">رقم الجوال</label>
                        <input type="tel" class="form-control form-control-lg" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required>
                        @error('phone_number')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">البريد الإلكتروني</label>
                        <input type="email" class="form-control form-control-lg" id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

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
                    <div class="mb-3">
                        <label for="iban" class="form-label">اسم البنك</label>
                        {{-- <input type="text" class="form-control" id="bank_name" name="bank_name" value="{{ old('bank_name') }}" required> --}}
                        <select id="bank_name" name="bank_name" class="form-select form-select-lg" value="{{ old('bank_name') }}" required>
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
                        <input type="text" class="form-control form-control-lg" id="bank_account_number" name="bank_account_number" value="{{ old('bank_account_number') }}" required>
                        @error('bank_account_number')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="iban" class="form-label">رقم الآيبان</label>
                        <input type="text" class="form-control form-control-lg" maxlength="24" minlength="24" id="iban" name="iban" value="{{ old('iban') }}" required>
                        @error('iban')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="id_photo" class="form-label">صورة من الأحوال (صورة الهوية الوطنية)</label>
                        <input type="file" class="form-control form-control-lg" id="id_photo" name="id_photo" required>
                        @error('id_photo')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">كلمة المرور</label>
                        <input type="text" class="form-control form-control-lg" id="password" name="password" required autocomplete="new-password">
                        @error('password')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">تأكيد كلمة المرور</label>
                        <input type="text" onkeyup="isMatched(this.value)" class="form-control form-control-lg" id="password_confirmation" name="password_confirmation" required>
                        <small class="password_match_status"></small>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input " id="terms_correct" name="terms_correct" required>
                        <label class="form-check-label" for="terms_correct">
                            أقر أن جميع البيانات المدخلة صحيحة.
                        </label>
                        @error('terms_correct')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input " onchange="document.querySelector('.terms_agreed').classList.toggle('d-none')" id="agree_no_illegal_use" name="agree_no_illegal_use" required>
                        <label class="form-check-label" for="agree_no_illegal_use">
                            <div class="mb-3 text-center fw-bold ">غير مصرّح باستخدام اللائحة لصندوق آخر</div>
                        </label>
                        @error('agree_no_illegal_use')
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
                    <div class="mb-3 form-check d-none terms_agreed">
                        <input type="checkbox" class="form-check-input" id="terms_agreed" name="terms_agreed" disabled>
                        <label class="form-check-labels" for="terms_agreed">
                            <span class=" text-dark">أوافق على شروط وأحكام اللائحة.</span>
                        </label>
                        <a href="#" class="btn btn-primary btn-lg my-1" data-bs-toggle="modal" data-bs-target="#termsModal">اللائحة المرفقة</a>.
                         @error('terms_agreed')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>



                    <button type="submit" id="submitForm" class="btn btn-primary btn-lg w-100" disabled>تسجيل</button>
                </form>
            </div>
            </main>
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
            const form = document.getElementById('myForm');
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
                // Prevent the form from submitting
                event.preventDefault();
                // **1. Call the isMatched function and get its return value**
                //    We pass the password confirmation value to the function
                const passwordConfirmation = document.getElementById('password_confirmation').value;
                const isPasswordMatched = isMatched(passwordConfirmation);
                console.log(isPasswordMatched);

                if (isPasswordMatched ===1 ) {
                    this.submit();
                } else {
                    // **3. Handle failed validations**
                    if (isPasswordMatched !== 1) {
                        // If passwords don't match, give feedback to the user
                        const inputElement = document.getElementById('password_confirmation');
                        inputElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }

                    if (!termsCheckbox.checked) {
                        // If terms are not checked, alert the user
                        alert('الرجاء الموافقة على الشروط والأحكام للمتابعة.');
                    }
                }
            });
            //  var passStatus = 0;
            function isMatched(match_password) {
                let pass = document.getElementById('password').value;
                var status = '';
                if(match_password==pass){
                    status = `<span class='text-success'>متطابق</span>`;
                    document.querySelector('.password_match_status').innerHTML = status;
                    return 1;
                }else{
                    status = `<span class='text-danger'>غير متطابق</span>`;
                    document.querySelector('.password_match_status').innerHTML = status;
                    return 0;
                }
            }
        });
        //  var passStatus = 0;
        function isMatched(match_password) {
            let pass = document.getElementById('password').value;
            var status = '';
            if(match_password==pass){
                status = `<span class='text-success'>متطابق</span>`;
                document.querySelector('.password_match_status').innerHTML = status;
                return 1;
            }else{
                status = `<span class='text-danger'>غير متطابق</span>`;
                document.querySelector('.password_match_status').innerHTML = status;
                return 0;
            }
        }

    </script>
</body>
</html>
