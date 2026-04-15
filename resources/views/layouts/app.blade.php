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
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset
            
            <div class="flex">
            <!-- SIDEBAR -->
            <aside class="w-64 bg-white border-r min-h-screen p-4 hidden md:block">
                <h2 class="text-lg font-semibold mb-6">Menu</h2>
                <nav class="space-y-2">
                    <!-- Dashboard -->
                    <a href="/dashboard"
                       class="block px-3 py-2 rounded transition
                       {{ request()->is('dashboard') ? 'bg-gray-200 font-semibold' : 'hover:bg-gray-100' }}">
                        Laporan Keuangan
                    </a>
                    <!-- Products -->
                    <a href="/products"
                       class="block px-3 py-2 rounded transition
                       {{ request()->is('products*') ? 'bg-gray-200 font-semibold' : 'hover:bg-gray-100' }}">
                        Products
                    </a>
                    <!-- Stock Ins Atau masuk -->
                    <a href="/stock-ins"
                        class="block px-3 py-2 rounded transition
                        {{ request()->is('stock-ins*') ? 'bg-gray-200 font-semibold' : 'hover:bg-gray-100' }}">
                            Stok Masuk
                    </a>
                    <a href="/stock-outs"
                        class="block px-3 py-2 rounded transition
                        {{ request()->is('stock-outs*') ? 'bg-gray-200 font-semibold' : 'hover:bg-gray-100' }}">
                            Stok Keluar
                    </a>
                    <a href="/pos"
                        class="block px-3 py-2 rounded transition
                        {{ request()->is('pos*') ? 'bg-gray-200 font-semibold' : 'hover:bg-gray-100' }}">
                            POS
                    </a>
                    <a href="/transactions"
                        class="block px-3 py-2 rounded transition
                        {{ request()->is('transactions*') && !request()->is('transactions/items*') ? 'bg-gray-200 font-semibold' : 'hover:bg-gray-100' }}">
                            Riwayat Transaksi
                    </a>                    
                    <a href="/transactions/items"
                        class="block px-3 py-2 rounded transition
                        {{ request()->is('transactions/items*') ? 'bg-gray-200 font-semibold' : 'hover:bg-gray-100' }}">
                            Detail Transaksi
                    </a>
                </nav>
            </aside>
            <!-- Page Content -->
            <main class="flex-1 p-6 bg-gray-50 min-h-screen flex flex-col">
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
