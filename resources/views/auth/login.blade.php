{{-- <x-guest-layout>
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

            <a href="/register" class="mr-3">Register</a>

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
</x-guest-layout> --}}

<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-slate-800">Selamat Datang!</h2>
        <p class="text-slate-500 text-sm mt-2">Silahkan masuk ke akun kasir Anda</p>
    </div>

    <!-- Session Status (Pesan Error/Sukses) -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <label class="block text-sm font-bold text-slate-700 mb-2">Email Kasir</label>
            <x-text-input id="email" 
                class="block w-full px-5 py-4 bg-slate-50 border-slate-100 rounded-2xl focus:ring-indigo-500/20 focus:border-indigo-500 transition" 
                type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-6">
            <div class="flex justify-between mb-2">
                <label class="text-sm font-bold text-slate-700">Password</label>
                @if (Route::has('password.request'))
                    <a class="text-xs font-semibold text-indigo-600 hover:text-indigo-700" href="{{ route('password.request') }}">
                        Lupa Password?
                    </a>
                @endif
            </div>
            <x-text-input id="password" 
                class="block w-full px-5 py-4 bg-slate-50 border-slate-100 rounded-2xl focus:ring-indigo-500/20 focus:border-indigo-500 transition"
                type="password" name="password" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="mt-6 flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded-lg border-slate-200 text-indigo-600 shadow-sm focus:ring-indigo-500/20" name="remember">
                <span class="ms-2 text-sm text-slate-500 font-medium">Ingat saya</span>
            </label>
            
            <a href="/register" class="text-sm font-bold text-slate-700 hover:text-indigo-600 transition">
                Daftar Akun
            </a>
        </div>

        <div class="mt-10">
            <button type="submit" class="w-full py-4 bg-indigo-600 text-white font-bold rounded-2xl shadow-xl shadow-indigo-200 hover:bg-indigo-700 transition transform hover:-translate-y-1 active:scale-95">
                Masuk Sekarang
            </button>
        </div>
    </form>
</x-guest-layout>
