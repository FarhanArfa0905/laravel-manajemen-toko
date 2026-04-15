<x-app-layout>
    <div class="max-w-6xl mx-auto mt-10">
        <h1 class="text-2xl font-bold mb-6">📜 Detail Transaksi</h1>
        {{-- FILTER --}}
        <form method="GET" class="flex gap-2 mb-4">
            <input type="date" name="date" class="border p-2 rounded">
            <input type="text" name="search"
                placeholder="Cari produk..."
                class="border p-2 rounded">

            <button class="bg-blue-500 text-white px-4 rounded">
                Filter
            </button>
        </form>
        {{-- TABLE --}}
        <div class="bg-white shadow rounded p-4">
            <table class="w-full border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2">Tanggal</th>
                        <th class="p-2">Produk</th>
                        <th class="p-2 text-center">Qty</th>
                        <th class="p-2 text-right">Harga</th>
                        <th class="p-2 text-right">Subtotal</th>
                        <th class="p-2 text-right">Profit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                    <tr class="border-t">
                        <td class="p-2">
                            {{ $item->transaction->created_at->format('d M Y H:i') }}
                        </td>

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

                        <td class="p-2 text-right text-green-600">
                            Rp {{ number_format($item->profit) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- PAGINATION --}}
            <div class="mt-4">
                {{ $items->links() }}
            </div>
        </div>
    </div>
</x-app-layout>