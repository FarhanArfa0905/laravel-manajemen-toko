<x-app-layout>
    {{-- Back Button --}}
    <div class="mb-4">
        <a href="/pos"
        class="bg-gray-500 text-white px-3 py-1 rounded">
            Kembali ke POS
        </a>
    </div>
    {{-- Content Invoice -> Hasil Checkout --}}
    <div class="max-w-2xl mx-auto mt-10 bg-white shadow rounded p-6">
        <h1 class="text-2xl font-bold mb-4 text-center">🧾 Invoice</h1>
        <div class="mb-4 text-sm text-gray-600">
            <p>ID Transaksi: #{{ $transaction->id }}</p>
            <p>Tanggal: {{ $transaction->created_at->format('d M Y H:i') }}</p>
        </div>
        <table class="w-full border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 text-left">Produk</th>
                    <th class="p-2 text-center">Qty</th>
                    <th class="p-2 text-right">Harga</th>
                    <th class="p-2 text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaction->items as $item)
                    <tr class="border-t">
                        <td class="p-2">
                            {{ $item->product->name }}
                        </td>
                        <td class="p-2 text-center">
                            {{ $item->qty }}
                        </td>
                        <td class="p-2 text-right">
                            Rp {{ number_format($item->selling_price) }}
                        </td>
                        <td class="p-2 text-right">
                            Rp {{ number_format($item->selling_price * $item->qty) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="text-right mt-4 text-lg font-bold">
            Total: Rp {{ number_format($transaction->total_price) }}
        </div>
        {{-- Action Button --}}
        <div class="flex justify-between mt-6">
            <a href="/transactions"
            class="bg-gray-500 text-white px-4 py-2 rounded">
                Kembali
            </a>
            <button onclick="window.print()"
                class="bg-green-600 text-white px-4 py-2 rounded">
                Print
            </button>
        </div>
    </div>
</x-app-layout>