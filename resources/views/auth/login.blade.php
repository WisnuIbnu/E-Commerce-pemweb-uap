<x-guest-layout title="Log In">

    <x-authentication-card>

        <div class="text-center mb-4">
            <h2 class="fw-bold" style="color:#1A2E49;">Welcome Back 👋</h2>
            <p class="text-muted" style="font-size:14px;">
                Senang melihatmu lagi! Yuk lanjutkan perjalanan manismu.
            </p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            {{-- Email --}}
            <div class="mb-3">
                <x-input-label value="Email" />
                <x-text-input type="email" name="email" required autofocus />
            </div>

            {{-- Password --}}
            <div class="mb-3">
                <x-input-label value="Password" />
                <x-text-input type="password" name="password" required />
            </div>

            {{-- Remember --}}
            <div class="d-flex align-items-center mb-3">
                <input id="remember" type="checkbox" name="remember"
                    style="width:16px;height:16px;margin-right:6px;">
                <label for="remember" class="text-muted" style="font-size:14px;">
                    Remember me
                </label>
            </div>

            {{-- Forgot --}}
            <div class="text-end mb-3">
                <a href="{{ route('password.request') }}" 
                   style="color:#6EA8FF; font-size:14px;">
                    Lupa password?
                </a>
            </div>
            
            {{-- Button --}}
            <x-primary-button>
                Log In
            </x-primary-button>
            
            {{-- Register link --}}
            <div class="text-center mt-4">
                <span class="text-dark fw-semibold">Belum punya akun?</span>
                <br>
                <a href="{{ route('register') }}"
                class="text-[#6EA8FF] fw-semibold text-decoration-none">
                    Daftar di sini
                </a>
            </div>

        </form>

    </x-authentication-card>

</x-guest-layout>