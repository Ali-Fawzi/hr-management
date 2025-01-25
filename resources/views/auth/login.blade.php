<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Form Title -->
    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
        Sign in to your account
    </h1>

    <form method="POST" action="{{ route('login') }}" class="space-y-4 md:space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Your email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password"
                            placeholder="••••••••" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between">
            <div class="flex items-start">
                <div class="flex items-center h-5">
                  <input id="remember_me" aria-describedby="remember_me" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300">
                </div>
                <div class="ml-3 text-sm">
                  <label for="remember_me" class="text-gray-500">{{ __('Remember me') }}</label>
                </div>
            </div>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm font-medium text-primary-600 hover:underline">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>
        <x-primary-button>
            {{ __('Sign in') }}
        </x-primary-button>
        <p class="text-sm font-light text-gray-500">
            Don’t have an account yet? <a href="{{ route('register') }}" class="font-medium text-primary-600 hover:underline">Sign up</a>
        </p>
    </form>
</x-guest-layout>
