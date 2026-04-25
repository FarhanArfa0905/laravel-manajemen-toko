<x-app-layout>
    <div class="py-6 px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Laporan Keuangan</h1>
                <p class="text-slate-500 text-sm mt-1">Pantau performa harian Ayra Cell secara real-time.</p>
            </div>

            {{-- Filter Area --}}
            <form method="GET" class="flex items-center gap-2 bg-white p-1.5 rounded-2xl shadow-sm border border-slate-100">
                <select name="range" class="border-none bg-transparent text-sm font-semibold focus:ring-0 text-slate-600 cursor-pointer">
                    <option value="today" {{ $range=='today'?'selected':'' }}>Hari Ini</option>
                    <option value="week" {{ $range=='week'?'selected':'' }}>Minggu Ini</option>
                    <option value="month" {{ $range=='month'?'selected':'' }}>Bulan Ini</option>
                </select>
                <button class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold px-5 py-2 rounded-xl transition shadow-lg shadow-indigo-100">
                    Filter
                </button>
            </form>
        </div>

        {{-- Statistik Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
            {{-- Card Pendapatan Masuk --}}
            <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex items-center gap-5">
                <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center shrink-0">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">Total Pendapatan</p>
                    <p class="text-2xl font-bold text-slate-800">Rp {{ number_format($totalRevenue) }}</p>
                </div>
            </div>

            {{-- Card Keuntungan --}}
            <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex items-center gap-5">
                <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center shrink-0">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                </div>
                <div>
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">Laba Bersih</p>
                    <p class="text-2xl font-bold text-emerald-600">Rp {{ number_format($totalProfit) }}</p>
                </div>
            </div>

            {{-- Card Jumlah Transaksi --}}
            <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex items-center gap-5 sm:col-span-2 lg:col-span-1">
                <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center shrink-0">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <div>
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">Total Transaksi</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $totalTransaction }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            {{-- Chart Penjualan --}}
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-bold text-slate-800">Grafik Penjualan</h2>
                </div>
                <div class="relative w-full h-[300px]">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>

            {{-- Produk Terlaris --}}
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
                <h2 class="text-lg font-bold text-slate-800 mb-6">Produk Terlaris</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-separate border-spacing-y-3">
                        <thead>
                            <tr class="text-slate-400 text-xs uppercase tracking-widest font-bold">
                                <th class="px-4 py-2">Nama Produk</th>
                                <th class="px-4 py-2 text-center">Terjual</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topProducts as $item)
                                <tr class="group bg-slate-50 hover:bg-indigo-50 transition-colors duration-200">
                                    <td class="px-4 py-4 rounded-l-2xl font-semibold text-slate-700">
                                        {{ $item->product->name ?? '-' }}
                                    </td>
                                    <td class="px-4 py-4 rounded-r-2xl text-center">
                                        <span class="inline-flex items-center px-3 py-1 bg-white border border-slate-200 rounded-lg text-sm font-bold text-indigo-600 shadow-sm">
                                            {{ $item->total }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Script JS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    const ctx = document.getElementById('salesChart').getContext('2d');
    
    // Gradient Background
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(79, 70, 229, 0.4)');
    gradient.addColorStop(1, 'rgba(79, 70, 229, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($labels),
            datasets: [{
                label: 'Pendapatan',
                data: @json($values),
                fill: true,
                backgroundColor: gradient,
                borderColor: '#4f46e5',
                borderWidth: 3,
                pointBackgroundColor: '#4f46e5',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#f1f5f9' },
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString();
                        },
                        font: { size: 11 }
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 11 } }
                }
            }
        }
    });
    </script>
</x-app-layout>