<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom border-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('home') }}">
            <!-- {{ $settings->storeName }} -->
            <img src="{{ asset('images/levanto.png') }}" height="44" alt="logo">
        </a>
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item dropdown">
                <a class="nav-link border px-4 py-1 rounded-3 clickable-cell" href="#" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="d-flex align-items-center">
                        <div class="me-2">
                            <img src="{{ Auth::user()->photo_url }}" alt="{{ Auth::user()->name }}"
                                class="rounded-circle border border-2 border-light" width="34">
                        </div>
                        <div class="me-1">
                            {{ Auth::user()->name }}
                        </div>
                        <x-heroicon-o-chevron-down class="hero-icon-xs" />
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm rounded-3 position-absolute">
                    <li>
                        <a class="dropdown-item disabled" href="#" dir="auto">
                            <div> {{ '@' . Auth::user()->username }}</div>
                            <div class="small text-muted"> {{ __(Auth::user()->role) }}</div>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center small" href="{{ route('profile.show') }}">
                            <x-heroicon-o-user class="hero-icon-sm text-gray-400 me-2" /> @lang('Profile')
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center small" href="{{ route('password.show') }}">
                            <x-heroicon-o-lock-closed class="hero-icon-sm text-gray-400 me-2" /> @lang('Change Password')
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center small" href="{{ route('logout') }}"
                            onclick="event.preventDefault();document.getElementById('navbar-logout-form').submit();">
                            <x-heroicon-o-arrow-left-on-rectangle class="hero-icon-sm text-gray-400 me-2" />
                            @lang('Logout')
                        </a>
                        <form id="navbar-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>

        </ul>
    </div>
</nav>
