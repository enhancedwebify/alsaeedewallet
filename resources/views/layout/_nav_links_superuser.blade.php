<ul class="nav flex-column mb-auto p-0">
    <li class="nav-item mb-2">
        <a href="{{ route('admin.dashboard') }}" class="nav-link text-white d-flex align-items-center">
            <i class="bi bi-speedometer2 ms-2"></i>
            لوحة التحكم
        </a>
    </li>
    <li class="nav-item mb-2">
        <a href="{{ route('admin.approvals.pending') }}" class="nav-link text-white d-flex align-items-center">
            <i class="bi bi-hourglass-split ms-2"></i>
            طلبات الموافقة المعلقة
        </a>
    </li>
    <li class="nav-item mb-2">
        <a href="{{ route('admin.users.index') }}" class="nav-link text-white d-flex align-items-center">
            <i class="bi bi-people-fill ms-2"></i>
            إدارة المستخدمين
        </a>
    </li>
    <li class="nav-item mb-2">
        <a href="{{ route('admin.contributions.index') }}" class="nav-link text-white d-flex align-items-center">
            <i class="bi bi-cash-stack ms-2"></i>
            إدارة المساهمات
        </a>
    </li>
    <li class="nav-item mb-2">
        <a href="{{ route('admin.loans.index') }}" class="nav-link text-white d-flex align-items-center">
            <i class="bi bi-arrow-down-up ms-2"></i>
            إدارة القروض
        </a>
    </li>
    <li class="nav-item mb-2">
        <a href="{{ route('admin.reports.index') }}" class="nav-link text-white d-flex align-items-center">
            <i class="bi bi-bar-chart-line-fill ms-2"></i>
            التقارير
        </a>
    </li>
    <li class="nav-item mb-2">
        <a href="{{ route('admin.settings') }}" class="nav-link text-white d-flex align-items-center">
            <i class="bi bi-gear-fill ms-2"></i>
            الإعدادات
        </a>
    </li>
</ul>
