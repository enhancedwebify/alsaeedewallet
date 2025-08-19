<ul class="nav flex-column mb-auto p-0">
    <li class="nav-item mb-2">
        <a href="{{ route('user.dashboard') }}" class="nav-link text-white d-flex align-items-center">
            <i class="bi bi-speedometer2 ms-2"></i>
            لوحة التحكم
        </a>
    </li>
    <li class="nav-item mb-2">
        <a href="{{ route('user.profile') }}" class="nav-link text-white d-flex align-items-center">
            <i class="bi bi-person-circle ms-2"></i>
            ملفي الشخصي
        </a>
    </li>
    <li class="nav-item mb-2">
        <a href="{{ route('contributions.index') }}" class="nav-link text-white d-flex align-items-center">
            <i class="bi bi-cash-stack ms-2"></i>
            مساهماتي
        </a>
    </li>
    <li class="nav-item mb-2">
        <a href="{{ route('loans.index') }}" class="nav-link text-white d-flex align-items-center">
            <i class="bi bi-arrow-down-up ms-2"></i>
            قروضي
        </a>
    </li>
    <li class="nav-item mb-2">
        <a href="{{ route('transactions.index') }}" class="nav-link text-white d-flex align-items-center">
            <i class="bi bi-card-list ms-2"></i>
            سجل العمليات
        </a>
    </li>
</ul>
