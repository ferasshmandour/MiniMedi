<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
    <div class="position-sticky pt-3">
        <a href="{{ route('dashboard') }}"
            class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none fs-4 px-3">
            🏥 MiniMedi
        </a>
        <hr class="text-secondary">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <i class="bi bi-speedometer2 me-2"></i>
                    {{ trans('messages.dashboard') }}
                </a>
            </li>
            @auth
                @if (auth()->user()->isAdmin())
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.doctors.*') ? 'active' : '' }}"
                            href="{{ route('admin.doctors.index') }}">
                            <i class="bi bi-person-badge me-2"></i>
                            {{ trans('messages.doctors') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.patients.*') ? 'active' : '' }}"
                            href="{{ route('admin.patients.index') }}">
                            <i class="bi bi-people me-2"></i>
                            {{ trans('messages.patients') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.appointments.*') ? 'active' : '' }}"
                            href="{{ route('admin.appointments.index') }}">
                            <i class="bi bi-calendar-event me-2"></i>
                            {{ trans('messages.appointments') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}"
                            href="{{ route('admin.roles.index') }}">
                            <i class="bi bi-shield-lock me-2"></i>
                            {{ trans('messages.permissions') }}
                        </a>
                    </li>
                @elseif(auth()->user()->isDoctor())
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('doctor.appointments.*') ? 'active' : '' }}"
                            href="{{ route('doctor.appointments.index') }}">
                            <i class="bi bi-calendar-event me-2"></i>
                            {{ trans('messages.appointments') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('doctor.medical-notes.*') ? 'active' : '' }}"
                            href="{{ route('doctor.medical-notes.index') }}">
                            <i class="bi bi-file-medical me-2"></i>
                            {{ trans('messages.medical_notes') }}
                        </a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}" href="{{ route('profile') }}">
                        <i class="bi bi-person me-2"></i>
                        {{ trans('messages.profile') }}
                    </a>
                </li>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-link btn-link text-start w-100">
                            <i class="bi bi-box-arrow-right me-2"></i>
                            {{ trans('messages.logout') }}
                        </button>
                    </form>
                </li>
            @endauth
        </ul>
        <hr class="text-secondary">
        <div class="px-3">
            @if (session('locale', 'en') == 'en')
                <a href="{{ route('language', 'ar') }}" class="btn btn-outline-light w-100 btn-sm">
                    🇸🇦 العربية
                </a>
            @else
                <a href="{{ route('language', 'en') }}" class="btn btn-outline-light w-100 btn-sm">
                    🇺🇸 English
                </a>
            @endif
        </div>
    </div>
</nav>
