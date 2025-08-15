<header class="position-relative" style="z-index: 1;">
    <!-- place navbar here -->
    <div class="logo w-100 mx-auto text-center">
        <a href="{{url("/")}}"><img src="{{asset('img/familyewallet.png')}}" alt="Menu Baseet" height="70px"></a>

    </div>
    <div class="btns py-3 px-3 mx-auto ">

        <nav class="nav justify-content-center bg-white  rounded-pill">
            <a class="text-decoration-none btn rounded-0 text-main nav-link border-start {{ request()->is('dashboard') ? 'fw-bold' : '' }}" href="{{url('/user/dashboard')}}">الإدارة</a>
            <a href="{{ url('logout') }}?{{ csrf_token() }}" class="text-decoration-none btn rounded-0 text-main nav-link">خروج</a>
        </nav>
    </div>

</header>
