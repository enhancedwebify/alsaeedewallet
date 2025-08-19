<nav id="sidebar" class="bg-dark text-white p-4 d-none d-md-block" style="width: 250px; position: fixed; top: 0; bottom: 0; right: 0; z-index: 1000;">
    <div class="sidebar-header text-center mb-4">
        <a href="{{ route('user.dashboard') }}">
            <img src="{{asset('img/familyewallet.png')}}" alt="شعار المحفظة" class="img-fluid" style="max-width: 100px;">
        </a>
        {{-- <h5 class="fw-bold mt-2">محفظة آل سعيّد</h5> --}}
    </div>
    @include('layout._nav_links')
    <div class="mt-auto px-3 ">
        <hr class="border-secondary">
        <a href="{{ route('logout') }}" class="nav-link  text-white d-flex align-items-center">
            <i class="bi bi-box-arrow-right ms-2"></i>
            تسجيل الخروج
        </a>

    </div>
</nav>

<div class="w-100 px-2 py-2">
    <a href="{{ route('user.dashboard') }}">
          <img src="{{asset('img/familyewallet.png')}}" alt="شعار المحفظة" class="img-fluid" style="max-width: 70px;">
      </a>

    <button class="btn float-start btn-primary d-md-none position-fixeds top-0 end-0 m-1" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar">
      <i class="bi bi-list"></i>
    </button>
</div>
<div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasSidebar" aria-labelledby="offcanvasSidebarLabel">
  <div class="offcanvas-header">
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      <h5 class="offcanvas-title" id="offcanvasSidebarLabel">القائمة</h5>
  </div>
  <div class="offcanvas-body">
    @include('layout._nav_links')
    <div class="mt-auto px-3">
        <hr class="border-secondary">
        <a href="{{ route('logout') }}" class="nav-link text-white d-flex align-items-center">
            <i class="bi bi-box-arrow-right me-2"></i>
            تسجيل الخروج
        </a>

    </div>
  </div>
</div>
