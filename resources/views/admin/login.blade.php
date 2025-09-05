<!doctype html>
<html lang="en" dir="rtl">
    <head>
        <title>دخول</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <style>

            #container header{
                height: 250px;
                max-height: 250px;

            }
        </style>
        {{-- <link rel="stylesheet" href="{{asset('css/sstyles.css')}}"> --}}
        {{-- <link rel="stylesheet" href="{{asset('css/styles.css')}}"> --}}
        @include('layout.head')
    </head>

    <body>
        <div id="__bring">
            {{-- @include('layout.header') --}}
            <div id="container" class="m-auto py-3 bg-  px-2 noto-sans-arabic position-relative" style="overflow: hidden;">
                <header class="d-flex position-relative" style="z-index: 1;">
                    <!-- place navbar here -->

                    <div class="logo w-50 mx-auto text-end">
                        <img src="{{asset('img/familyewallet.png')}}" height="70">

                    </div>
                    <div class="btns w-50 mx-auto text-start">
                        <a href="{{url('/')}}" class="btn btn-primary">رجوع <i class="bi bi-arrow-left"></i></a>
                    </div>
                    <div class="position-absolute w-100 d-flex justify-content-center" style="z-index: -1;top: 100px;">
                        <div class="liquid_shape justify-content-center text-white" style="  display: flex;align-items: center;"> <div class="fw-bold h1 text-center">مرحبا بالإدارة،،،</div></div>
                    </div>
                </header>
                <main class="pt-5 pb-3">
                    <div class="title  pt-5">
                        <div class="px-4">
                            {{-- @if (\Session::has('email'))
                                <div
                                    class="alert alert-danger alert-dismissible fade show"
                                    role="alert"
                                >
                                    <button
                                        type="button"
                                        class="btn-close"
                                        data-bs-dismiss="alert"
                                        aria-label="Close"
                                    ></button>

                                    <strong>*</strong> {!! \Session::get('email') !!}
                                </div>
                            @endif --}}
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            <form action="{{route('admin.login')}}" method="post">
                                @csrf
                                <div class="forminput">

                                    <div class="form-floating mb-3">
                                        <input dir="ltr" autocomplete required name="email" type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                                        <label for="floatingInput" style="right:0;left:auto;margin:0;">البريد الإلكتروني</label>
                                    </div>
                                    <div class="form-floating">
                                        <input dir="ltr" autocomplete required name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password">
                                        <label for="floatingPassword" style="right:0;left:auto;margin:0;">كلمة المرور</label>
                                    </div>

                                </div>
                                <div class="getStarted py-3 text-center">
                                    <button type="submit" class="btn btn-lg btn-primary w-100">دخول</button>
                                </div>
                            </form>
                            <div class="text-center position-relative">
                                <hr>
                                <div class="position-absolute btn bg-white px-1 p-0" style="top: -12px">أو</div>
                                <div class="py-3"><a href="" class="text-decoration-none text-main" data-bs-toggle="modal" data-bs-target="#resetPassword">نسيت كلمة المرور؟</a></div>
                            </div>
                        </div>
                         <!-- Modal 4 [Forgot Password] -->
                         <div class="modal fade" id="resetPassword" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header" dir="rtl">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">إعادة تعيين كلمة المرور</h1>
                                    </div>
                                    <form action="{{url('forgot-password')}}" method="post">
                                        @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="" class="form-label fw-bold">البريد الالكتروني</label>
                                            <input type="email" id="email" name="email" class="form-control my-1" >
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                                        <button type="submit" class="btn btn-primary">إرسال</button>
                                    </div>
                                    </form>
                                </div>
                                </div>
                        </div>
                        <!-- End Modal 4 -->
                    </div>
                </main>

            </div>
        </div>
    </body>
</html>
