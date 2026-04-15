<x-app-layout>
    {{-- Content Utama History/Riwayat Penjualan --}}
    <div class="max-w-4xl mx-auto mt-10 bg-white shadow rounded p-6">
        <h1 class="text-2xl font-bold mb-6">Riwayat Transaksi</h1>
        <table class="w-full border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 text-left">ID</th>
                    <th class="p-2 text-left">Tanggal</th>
                    <th class="p-2 text-right">Total</th>
                    <th class="p-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $trx)
                    <tr class="border-t">
                        <td class="p-2">#{{ $trx->id }}</td>
                        <td class="p-2">
                            {{ $trx->created_at->format('d M Y H:i') }}
                        </td>
                        <td class="p-2 text-right">
                            Rp {{ number_format($trx->total_price) }}
                        </td>
                        <td class="p-2 text-center">
                            <a href="/pos/invoice/{{ $trx->id }}"
                            class="bg-blue-500 text-white px-3 py-1 rounded">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center p-4 text-gray-500">
                            Belum ada transaksi
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>