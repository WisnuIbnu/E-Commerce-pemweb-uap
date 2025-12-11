<x-guest-layout title="Register">

    <x-authentication-card>

        <div class="text-center mb-4">
            <h2 class="fw-bold" style="color:#1A2E49;">Create Your Account</h2>
            <p class="text-muted" style="font-size:14px;">
                Bergabunglah dan temukan dessert favoritmu bersama kami🧁
            </p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- Name --}}
            <div class="mb-3">
                <x-input-label value="Name" />
                <x-text-input type="text" name="name" required />
            </div>

            {{-- Email --}}
            <div class="mb-3">
                <x-input-label value="Email" />
                <x-text-input type="email" name="email" required />
            </div>

            {{-- Password --}}
            <div class="mb-3">
                <x-input-label value="Password" />
                <x-text-input type="password" name="password" required />
            </div>

            {{-- Confirm --}}
            <div class="mb-3">
                <x-input-label value="Confirm Password" />
                <x-text-input type="password" name="password_confirmation" required />
            </div>

            {{-- Button --}}
            <x-primary-button>
                Register
            </x-primary-button>

            {{-- Already --}}
            <div class="text-center mt-3">
                <span class="text-dark fw-semibold">Sudah punya akun?</span>
                <br>
                <a href="{{ route('login') }}"
                class="text-[#6EA8FF] fw-semibold text-decoration-none">
                    Login di sini
                </a>
            </div>

        </form>

    </x-authentication-card>

</x-guest-layout>