<nav x-data="{ open: false, profileOpen: false }" class="bg-gray-800">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">

        <!-- LEFT -->
        <div class="flex items-center">
            <div class="shrink-0">
            <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500"
                class="size-8" />
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:block">
            <div class="ml-10 flex items-baseline space-x-4">
                {{-- Tombol Home --}}
                <x-nav-link href="/" :active="request()->is('/') ">Home</x-nav-link>
                <x-nav-link href="/about" :active="request()->is('about') ">About</x-nav-link>
                <x-nav-link href="/posts" :active="request()->is('posts') ">Blog</x-nav-link>
                <x-nav-link href="/contact" :active="request()->is('contact') ">Contact</x-nav-link>
            </div>
            </div>
        </div>

        <!-- RIGHT -->
        <div class="hidden md:flex items-center space-x-4">
            <!-- Profile Dropdown -->
            <div class="relative">
            <button @click="profileOpen = !profileOpen"
                    class="flex rounded-full focus:outline-none">
                <img class="size-8 rounded-full"
                src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e"
                alt="">
            </button>

            <!-- Dropdown -->
            <div x-show="profileOpen"
                @click.outside="profileOpen = false"
                x-transition
                class="absolute right-0 mt-2 w-48 rounded-md bg-white py-1 shadow-lg z-50">
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Your Profile</a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sign out</a>
            </div>
            </div>
        </div>

        <!-- Mobile Button -->
        <div class="md:hidden">
            <button @click="open = !open"
            class="rounded-md p-2 text-gray-400 hover:bg-white/5 hover:text-white">
            <svg x-show="!open" class="size-6" fill="none" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round"
                d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
            </svg>
            <svg x-show="open" class="size-6" fill="none" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round"
                d="M6 18 18 6M6 6l12 12"/>
            </svg>
            </button>
        </div>

        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" x-transition class="md:hidden bg-gray-800">
        
        <div class="space-y-1 px-2 pt-2 pb-3">
                <x-nav-link href="/" :active="request()->is('/') ">Home</x-nav-link>
                <x-nav-link href="/about" :active="request()->is('about') ">About</x-nav-link>
                <x-nav-link href="/posts" :active="request()->is('posts') ">Blog</x-nav-link>
                <x-nav-link href="/contact" :active="request()->is('contact') ">Contact</x-nav-link>
        </div>

        <!-- Profile section mobile -->
        <div class="border-t border-white/10 pt-4 pb-3">
            <div class="flex items-center px-5">
                <div class="shrink-0">
                    <img class="size-10 rounded-full"
                        src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e"
                        alt="">
                </div>
                <div class="ml-3">
                    <div class="text-base font-medium text-white">Tom Cook</div>
                    <div class="text-sm font-medium text-gray-400">tom@example.com</div>
                </div>
            </div>

            <div class="mt-3 space-y-1 px-2">
                <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-white/5 hover:text-white">
                    Your Profile
                </a>
                <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-white/5 hover:text-white">
                    Settings
                </a>
                <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-white/5 hover:text-white">
                    Sign out
                </a>
            </div>
        </div>
    </div>
</nav>