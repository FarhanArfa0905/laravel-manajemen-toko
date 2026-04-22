<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ayra Cell - Modern Counter & Transfer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass-nav {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900">

    <!-- NAVBAR -->
    <nav class="glass-nav sticky top-0 z-50 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between h-20 items-center">
                
                <!-- Logo -->
                <div class="flex items-center space-x-2">
                    <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-200">
                        <span class="text-white font-bold text-xl">A</span>
                    </div>
                    <span class="text-2xl font-bold tracking-tight text-slate-800">
                        Ayra<span class="text-indigo-600">Cell</span>
                    </span>
                </div>

                <!-- Nav Links & Login (Desktop) -->
                <div class="hidden md:flex items-center space-x-10">
                    <div class="flex space-x-8">
                        <a href="#" class="text-sm font-semibold text-slate-600 hover:text-indigo-600 transition">Beranda</a>
                        <a href="/kontak" class="text-sm font-semibold text-slate-600 hover:text-indigo-600 transition">Kontak</a>
                    </div>
                    
                    <div class="h-6 w-[1px] bg-slate-200"></div>

                    <!-- Tombol Login Kasir -->
                    <a href="/login" class="inline-flex items-center px-6 py-2.5 border border-transparent text-sm font-bold rounded-xl text-white bg-slate-900 hover:bg-slate-800 shadow-xl shadow-slate-200 transition transform hover:-translate-y-0.5">
                        Login Kasir
                    </a>
                </div>

                <!-- Mobile Button -->
                <div class="md:hidden">
                    <button class="p-2 text-slate-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <header class="relative pt-20 pb-20 overflow-hidden bg-white">
        <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
            <span class="px-4 py-2 rounded-full bg-indigo-50 text-indigo-600 text-xs font-bold uppercase tracking-wider">Terpercaya & Cepat</span>
            <h1 class="mt-8 text-5xl md:text-7xl font-extrabold text-slate-900 tracking-tight leading-tight">
                Transaksi Digital <br> <span class="text-indigo-600 italic">Tanpa Ribet.</span>
            </h1>
            <p class="mt-6 text-lg text-slate-500 max-w-2xl mx-auto leading-relaxed">
                Ayra Cell hadir sebagai pusat layanan top-up, pembayaran tagihan, hingga jasa transfer bank dan e-wallet dengan proses instan.
            </p>
            <div class="mt-10 flex justify-center space-x-4">
                <a href="#layanan" class="px-8 py-4 bg-indigo-600 text-white font-bold rounded-2xl shadow-2xl shadow-indigo-200 hover:bg-indigo-700 transition duration-300">Mulai Transaksi</a>
            </div>
        </div>
        
        <!-- Elemen Dekoratif -->
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full opacity-10 pointer-events-none">
            <div class="absolute top-20 left-10 w-64 h-64 bg-indigo-400 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-10 w-96 h-96 bg-blue-400 rounded-full blur-3xl"></div>
        </div>
    </header>

    <!-- LAYANAN SECTION -->
    <section id="layanan" class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <!-- Layanan 1 -->
                <div class="group p-10 bg-white rounded-[2rem] border border-slate-100 hover:border-indigo-200 transition-all duration-300 shadow-sm hover:shadow-2xl hover:shadow-indigo-100/50">
                    <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-8 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-3">Pulsa & Data</h3>
                    <p class="text-slate-500 leading-relaxed text-sm">Isi ulang kuota internet dan pulsa semua operator lokal & internasional tersedia 24 jam.</p>
                </div>

                <!-- Layanan 2 -->
                <div class="group p-10 bg-white rounded-[2rem] border border-slate-100 hover:border-indigo-200 transition-all duration-300 shadow-sm hover:shadow-2xl hover:shadow-indigo-100/50">
                    <div class="w-14 h-14 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center mb-8 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-3">Token & Tagihan</h3>
                    <p class="text-slate-500 leading-relaxed text-sm">Pembayaran Token PLN, BPJS, PDAM, hingga cicilan bulanan lebih praktis dan murah.</p>
                </div>

                <!-- Layanan 3: JASA TRANSFER -->
                <div class="group p-10 bg-white rounded-[2rem] border border-indigo-100 ring-2 ring-indigo-50 hover:border-indigo-200 transition-all duration-300 shadow-xl shadow-indigo-100/20 hover:shadow-2xl">
                    <div class="w-14 h-14 bg-indigo-600 text-white rounded-2xl flex items-center justify-center mb-8 group-hover:scale-110 transition-transform duration-300 shadow-lg shadow-indigo-200">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-3 text-indigo-600">Transfer & Tarik Tunai</h3>
                    <p class="text-slate-500 leading-relaxed text-sm">
                        Kirim uang ke seluruh Bank di Indonesia atau Top Up & Tarik Tunai saldo <b>DANA, OVO, ShopeePay, & GoPay</b> secara instan.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- FOOTER / KONTAK -->
    <footer id="kontak" class="bg-white border-t border-slate-80 pt-20 pb-10">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center">
            <div class="mb-8 md:mb-0">
                <span class="text-xl font-bold text-slate-800">Ayra Cell</span>
                <p class="text-slate-500 mt-2 text-sm">Jl. Raya Utama No. 123, Indonesia</p>
            </div>
            <div class="flex space-x-6 text-sm font-semibold text-slate-600">
                <a href="https://wa.me/628123456789" class="hover:text-green-500 transition flex items-center">
                    WhatsApp Kami →
                </a>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-6 mt-16 pt-8 border-t border-slate-50 text-center text-xs text-slate-400">
            &copy; 2026 Ayra Cell
        </div>
    </footer>

</body>
</html>