<x-app-layout>
    {{-- Filter --}}
    <form method="GET" class="mb-6 flex gap-2">
        <select name="range" class="border p-2 rounded">
            <option value="today" {{ $range=='today'?'selected':'' }}>Hari Ini</option>
            <option value="week" {{ $range=='week'?'selected':'' }}>Minggu Ini</option>
            <option value="month" {{ $range=='month'?'selected':'' }}>Bulan Ini</option>
        </select>
        <button class="bg-blue-500 text-white px-4 rounded">
            Filter
        </button>
    </form>
    {{-- Content Utama Dashboard Laporan Penjualan --}}
    <div class="max-w-6xl mx-auto mt-10">
        <h1 class="text-2xl font-bold mb-6">📊 Dashboard</h1>
        {{-- Card --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

            <div class="bg-white p-4 shadow rounded">
                <p class="text-gray-500">Total Hari Ini</p>
                <p class="text-2xl font-bold tracking-tight">
                    Rp {{ number_format($totalRevenue) }}
                </p>
            </div>
            <div class="bg-white p-4 shadow rounded">
                <p class="text-gray-500">Profit Hari Ini</p>
                <p class="text-2xl font-bold tracking-tight text-green-600">
                    Rp {{ number_format($totalProfit) }}
                </p>
            </div>
            <div class="bg-white p-4 shadow rounded">
                <p class="text-gray-500">Jumlah Transaksi</p>
                <p class="text-2xl font-bold tracking-tight">
                    {{ $totalTransaction }}
                </p>
            </div>
        </div>

        {{-- Produk Teratas Penjualan --}}
        <div class="bg-white p-6 shadow rounded">
            <h2 class="text-lg font-semibold mb-4"> Produk Terlaris</h2>
            <table class="w-full border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 text-left">Produk</th>
                        <th class="p-2 text-center">Terjual</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topProducts as $item)
                        <tr class="border-t">
                            <td class="p-2">
                                {{ $item->product->name ?? '-' }}
                            </td>
                            <td class="p-2 text-center">
                                {{ $item->total }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{-- Chart / Grafik Penjualan --}}
        <div class="bg-white p-6 shadow rounded mt-6">
            <h2 class="text-lg font-semibold mb-4">📊 Grafik Penjualan</h2>
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    {{-- Script JS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    const ctx = document.getElementById('salesChart');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($labels),
            datasets: [{
                label: 'Revenue',
                data: @json($values),
                borderWidth: 2,
                tension: 0.3
            }]
        },
    });
    </script>
</x-app-layout>