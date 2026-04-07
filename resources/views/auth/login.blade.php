<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    @php
        $googleAuthEnabled = filled(config('services.google.client_id'))
            && filled(config('services.google.client_secret'))
            && filled(config('services.google.redirect'));
    @endphp

    @if($googleAuthEnabled)
        <div class="mb-6 space-y-4">
            <a
                href="{{ route('google.login') }}"
                class="flex w-full items-center justify-center gap-3 rounded-md border border-[#E5E0D8] bg-white px-4 py-3 text-sm font-medium text-[#1A1814] transition hover:border-[#D4542A] hover:text-[#D4542A]"
            >
                <svg class="h-5 w-5" viewBox="0 0 24 24" aria-hidden="true">
                    <path fill="#EA4335" d="M12 10.2v3.9h5.5c-.2 1.2-.9 2.2-1.9 2.9l3 2.4c1.8-1.7 2.8-4.1 2.8-6.9 0-.6-.1-1.2-.2-1.8H12z"/>
                    <path fill="#34A853" d="M12 21c2.5 0 4.7-.8 6.3-2.2l-3-2.4c-.8.6-1.9 1-3.3 1-2.5 0-4.7-1.7-5.5-4H3.4v2.5A9.5 9.5 0 0012 21z"/>
                    <path fill="#FBBC05" d="M6.5 13.4a5.7 5.7 0 010-3.6V7.3H3.4a9.5 9.5 0 000 8.6l3.1-2.5z"/>
                    <path fill="#4285F4" d="M12 6.8c1.4 0 2.7.5 3.7 1.4l2.8-2.8C16.7 3.8 14.5 3 12 3a9.5 9.5 0 00-8.6 5.3l3.1 2.5c.8-2.3 3-4 5.5-4z"/>
                </svg>
                Continue with Google
            </a>

            <div class="flex items-center gap-3 text-xs uppercase tracking-[0.3em] text-[#A09890]">
                <div class="h-px flex-1 bg-[#E5E0D8]"></div>
                <span>or</span>
                <div class="h-px flex-1 bg-[#E5E0D8]"></div>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
