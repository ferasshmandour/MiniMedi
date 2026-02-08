<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="{{ route('dashboard') }}">
        🏥 MiniMedi
    </a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse"
        data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="w-100"></div>
    <div class="navbar-nav">
        <div class="nav-item text-nowrap d-flex align-items-center px-3">
            @auth
                <span class="text-white me-3">
                    <i class="bi bi-person-circle me-1"></i>
                    {{ auth()->user()->name }}
                </span>
                @if (session('locale', 'en') == 'en')
                    <a href="{{ route('language', 'ar') }}" class="btn btn-outline-light btn-sm">
                        🇸🇦 العربية
                    </a>
                @else
                    <a href="{{ route('language', 'en') }}" class="btn btn-outline-light btn-sm">
                        🇺🇸 English
                    </a>
                @endif
            @endauth
        </div>
    </div>
</header>
