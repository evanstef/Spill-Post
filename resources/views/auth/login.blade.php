<x-guest-layout>
    {{-- title --}}
    <x-slot name="title">
        {{ __('Login') }}
    </x-slot>
{{-- akhir title --}}
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

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
            <x-input-label for="password_login" :value="__('Password')" />

            <div class="relative">
               <x-text-input id="password_login" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
                <svg class="w-6 h-6 absolute top-2 right-2" id="show_login_password" viewBox="0 0 16 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path class="fill-white" d="M8 16C7.46957 16 6.96086 15.7893 6.58579 15.4142C6.21071 15.0391 6 14.5304 6 14C6 12.89 6.89 12 8 12C8.53043 12 9.03914 12.2107 9.41421 12.5858C9.78929 12.9609 10 13.4696 10 14C10 14.5304 9.78929 15.0391 9.41421 15.4142C9.03914 15.7893 8.53043 16 8 16ZM14 19V9H2V19H14ZM14 7C14.5304 7 15.0391 7.21071 15.4142 7.58579C15.7893 7.96086 16 8.46957 16 9V19C16 19.5304 15.7893 20.0391 15.4142 20.4142C15.0391 20.7893 14.5304 21 14 21H2C1.46957 21 0.960859 20.7893 0.585786 20.4142C0.210714 20.0391 0 19.5304 0 19V9C0 7.89 0.89 7 2 7H3V5C3 3.67392 3.52678 2.40215 4.46447 1.46447C5.40215 0.526784 6.67392 0 8 0C8.65661 0 9.30679 0.129329 9.91342 0.380602C10.52 0.631876 11.0712 1.00017 11.5355 1.46447C11.9998 1.92876 12.3681 2.47995 12.6194 3.08658C12.8707 3.69321 13 4.34339 13 5V7H14ZM8 2C7.20435 2 6.44129 2.31607 5.87868 2.87868C5.31607 3.44129 5 4.20435 5 5V7H11V5C11 4.20435 10.6839 3.44129 10.1213 2.87868C9.55871 2.31607 8.79565 2 8 2Z" fill="black"/>
                </svg>
                <svg class="w-6 h-6 absolute hidden top-2 right-2" id="hide_login_password" viewBox="0 0 21 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path class="fill-white" d="M7.89 4.82L6.25 3.16C6.61716 2.2286 7.256 1.42917 8.08348 0.865621C8.91097 0.302074 9.88884 0.000466917 10.89 0C13.65 0 15.89 2.24 15.89 5V7H16.89C17.4204 7 17.9291 7.21071 18.3042 7.58579C18.6793 7.96086 18.89 8.46957 18.89 9V15.8L16.89 13.8V9H12.09L10.09 7H13.89V5C13.89 3.34 12.55 2 10.89 2C9.3 2 8 3.25 7.89 4.82ZM21 20.46L19.73 21.73L18.35 20.35C17.99 20.75 17.47 21 16.89 21H4.89C4.35957 21 3.85086 20.7893 3.47579 20.4142C3.10071 20.0391 2.89 19.5304 2.89 19V9C2.89 7.89 3.78 7 4.89 7H5L0 2L1.28 0.73L21 20.46ZM16.89 18.89L12.74 14.74C12.45 15.5 11.73 16 10.89 16C10.3596 16 9.85086 15.7893 9.47579 15.4142C9.10071 15.0391 8.89 14.5304 8.89 14C8.89 13.15 9.39 12.44 10.15 12.15L7 9H4.89V19H16.89V18.89Z" fill="black"/>
                </svg>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        {{-- <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div> --}}

        <div class="flex items-center justify-between mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-xs text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <a href="{{ route('register') }}" class="underline text-xs text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                {{ __("Don't have an account?") }}
            </a>

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

<script>
    const passwordInputLogin = document.getElementById('password_login');
    const showLoginPassword = document.getElementById('show_login_password');
    const hideLoginPassword = document.getElementById('hide_login_password');

    showLoginPassword.addEventListener('click', () => {
        passwordInputLogin.setAttribute('type', 'text');
        showLoginPassword.classList.add('hidden');
        hideLoginPassword.classList.remove('hidden');
    });

    hideLoginPassword.addEventListener('click', () => {
        passwordInputLogin.setAttribute('type', 'password');
        showLoginPassword.classList.remove('hidden');
        hideLoginPassword.classList.add('hidden');
    });

</script>
