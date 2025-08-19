<nav id="sidebar" class="bg-dark text-white p-4 d-none d-md-block" style="width: 250px; position: fixed; top: 0; bottom: 0; right: 0; z-index: 1000;">
    <div class="sidebar-header text-center mb-4">
        <a href="{{ route('user.dashboard') }}">
            <img src="{{asset('img/familyewallet.png')}}" alt="شعار المحفظة" class="img-fluid" style="max-width: 100px;">
        </a>
        <h5 class="fw-bold mt-2">محفظة آل سعيّد</h5>
    </div>
    @include('layout._nav_links')
    <div class="mt-auto">
        <hr class="border-secondary">
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link text-white d-flex align-items-center">
            <i class="bi bi-box-arrow-right me-2"></i>
            تسجيل الخروج
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
</nav>

<button class="btn btn-dark d-md-none position-fixed top-0 end-0 m-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar">
  <span class="navbar-toggler-icon"></span>
</button>

<div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasSidebar" aria-labelledby="offcanvasSidebarLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasSidebarLabel">القائمة</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    @include('layout._nav_links')

  </div>
</div>
