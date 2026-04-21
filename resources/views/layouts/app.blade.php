<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        @php
            $sidebarMenus = [
                ['label' => 'Laporan Keuangan', 'href' => '/dashboard', 'active' => request()->is('dashboard')],
                ['label' => 'Products', 'href' => '/products', 'active' => request()->is('products*')],
                ['label' => 'Stok Masuk', 'href' => '/stock-ins', 'active' => request()->is('stock-ins*')],
                ['label' => 'Stok Keluar', 'href' => '/stock-outs', 'active' => request()->is('stock-outs*')],
                ['label' => 'POS', 'href' => '/pos', 'active' => request()->is('pos*')],
                ['label' => 'Riwayat Transaksi', 'href' => '/transactions', 'active' => request()->is('transactions*') && !request()->is('transactions/items*')],
                ['label' => 'Detail Transaksi', 'href' => '/transactions/items', 'active' => request()->is('transactions/items*')],
            ];
        @endphp

        <div x-data="{ sidebarOpen: false }" class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset
            
            <div class="flex relative">
            <!-- Mobile sidebar backdrop -->
            <div
                x-cloak
                x-show="sidebarOpen"
                x-transition.opacity
                class="fixed inset-0 z-30 bg-gray-900/50 md:hidden"
                @click="sidebarOpen = false"
            ></div>

            <!-- SIDEBAR -->
            <aside
                class="block fixed inset-y-0 left-0 z-40 w-64 bg-white border-r min-h-screen p-4 transform transition-transform duration-300 ease-in-out md:static md:translate-x-0"
                :class="{ 'translate-x-0 block': sidebarOpen, '-translate-x-full': !sidebarOpen }"
                x-cloak
            >
                <h2 class="text-lg font-semibold mb-6">Menu</h2>
                <nav class="space-y-2">
                    <div class="flex items-center justify-between md:hidden mb-4">
                        <h2 class="text-lg font-semibold">Navigasi</h2>
                        <button
                            type="button"
                            class="rounded-md p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700"
                            @click="sidebarOpen = false"
                        >
                            <span class="sr-only">Tutup sidebar</span>
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    @foreach ($sidebarMenus as $menu)
                        <a href="{{ $menu['href'] }}"
                           class="block px-3 py-2 rounded transition {{ $menu['active'] ? 'bg-gray-200 font-semibold text-gray-900' : 'text-gray-700 hover:bg-gray-100' }}"
                           @click="sidebarOpen = false">
                            {{ $menu['label'] }}
                        </a>
                    @endforeach
                </nav>
            </aside>
            <!-- Page Content -->
            <main class="flex-1 bg-gray-50 min-h-screen flex flex-col p-4 sm:p-6">
                <div class="mb-4 md:hidden">
                    <button
                        type="button"
                        class="inline-flex items-center gap-2 rounded-md bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm ring-1 ring-gray-200 hover:bg-gray-50"
                        @click="sidebarOpen = true"
                    >
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        Menu
                    </button>
                </div>

                <div class="flex-1">
                    {{ $slot }}
                </div>
            </main>
            </div>
        </div>
    </body>

    {{-- Script JS --}}
    @if(session('success'))
    <script>
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: "{{ session('success') }}",
        showConfirmButton: false,
        timer: 2000
    });
    </script>
    @endif

    @if(session('error'))
    <script>
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'error',
        title: "{{ session('error') }}",
        showConfirmButton: false,
        timer: 2000
    });
    </script>
    @endif

    <script>
    function handleCheckout(btn) {
        btn.disabled = true;
        btn.innerText = 'Loading...';

        openModal();

        setTimeout(() => {
            btn.disabled = false;
            btn.innerText = 'Checkout';
        }, 1000);
    }
    </script>
    
    {{-- @if(session('success'))
    <script>
        Swal.fire({
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            icon: 'success',
            timer: 2000,
            showConfirmButton: false
        });
    </script>
    @endif --}}
</html>
