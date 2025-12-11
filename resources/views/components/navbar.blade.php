<nav class="navbar navbar-expand-lg bg-white shadow-sm py-3">
    <div class="container">

        <a class="navbar-brand fw-bold" href="/">
            SweetMart 🍰
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav ms-auto align-items-center gap-3">

                <li class="nav-item">
                    <a class="nav-link" href="/products">Products</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/cart">Cart</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/transactions">Transactions</a>
                </li>

                @auth
                {{-- PROFILE DROPDOWN --}}
                <li class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle fw-semibold" href="#" id="profileDropdown"
                       role="button" data-bs-toggle="dropdown">
                       {{ Auth::user()->name }}
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end">

                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                Profile
                            </a>
                        </li>

                        <li><hr class="dropdown-divider"></li>

                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item text-danger">Logout</button>
                            </form>
                        </li>

                    </ul>
                </li>
                @else

                {{-- LOGIN BUTTON --}}
                <li>
                    <a href="/login" class="btn btn-outline-primary px-3">
                        Login
                    </a>
                </li>

                @endauth
            </ul>
        </div>

    </div>
</nav>