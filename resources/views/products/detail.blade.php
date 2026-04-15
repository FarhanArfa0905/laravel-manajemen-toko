<x-app-layout>
    <div class="max-w-5xl mx-auto mt-10 flex flex-col min-h-[85vh]">
        {{-- Pop Up Atas --}}
        <a href="/products"
           class="bg-blue-500 text-white px-4 py-2 rounded mb-4">
            Kembali
        </a>
        {{-- Content --}}
        <div class="bg-white shadow rounded p-6 space-y-4">
            <h1 class="text-2xl font-bold">{{ $product->name }}</h1>
            <div class="text-gray-600">
                <p>Total Stock: <span class="font-semibold">
                    {{ $product->stockIns->sum('remaining_qty') }}
                </span></p>
                <p>Harga: Rp {{ number_format($product->price) }}</p>
            </div>
            <h2 class="text-lg font-semibold mt-4">Detail Stok</h2>
            <table class="w-full border mt-2">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 text-left">Qty Awal</th>
                        <th class="p-2 text-left">Sisa</th>
                        <th class="p-2 text-left">Expired</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($product->stockIns as $stock)
                    <tr class="border-t">
                        <td class="p-2">{{ $stock->qty }}</td>
                        <td class="p-2">{{ $stock->remaining_qty }}</td>
                        <td class="p-2">
                            {{ $stock->expired_date ?? '-' }}
                        </td>
                        <td class="p-2 {{ $stock->sisa == 0 ? 'text-red-500 font-bold' : '' }}"></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>