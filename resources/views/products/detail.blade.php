<x-app-layout>
    <div class="max-w-6xl mx-auto mt-10 flex flex-col min-h-[85vh]">
        <a href="/products"
           class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded mb-4 w-fit">
            Kembali
        </a>

        <div class="bg-white shadow rounded p-6 space-y-6">
            <div class="flex flex-col md:flex-row gap-6">
                {{-- Image  / Foto Produk --}}
                <div class="w-full md:w-56 shrink-0">
                    <div class="w-full h-56 bg-gray-100 rounded border overflow-hidden flex items-center justify-center">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}"
                                 alt="{{ $product->name }}"
                                 class="w-full h-full object-cover">
                        @else
                            <span class="text-sm text-gray-400">No Image</span>
                        @endif
                    </div>
                </div>
                {{-- Nama Produk + Kategori Produk --}}
                <div class="flex-1">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <h1 class="text-2xl font-bold text-gray-800">{{ $product->name }}</h1>

                        <span class="w-fit text-xs px-3 py-1 rounded-full
                            {{ $product->type === \App\Models\Product::TYPE_FISIK ? 'bg-amber-100 text-amber-700' : 'bg-sky-100 text-sky-700' }}">
                            {{ $product->type_label }}
                        </span>
                    </div>
                    {{-- Field Loop --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-4 text-sm text-gray-600">
                        <p>
                            <span class="font-medium text-gray-800">Kode:</span>
                            {{ $product->code ?? '-' }}
                        </p>
                        <p>
                            <span class="font-medium text-gray-800">Kategori:</span>
                            {{ $product->category_label }}
                        </p>
                        <p>
                            <span class="font-medium text-gray-800">Provider:</span>
                            {{ $product->provider ?? '-' }}
                        </p>
                        <p>
                            <span class="font-medium text-gray-800">Harga Jual:</span>
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>
                        <p>
                            <span class="font-medium text-gray-800">Harga Modal:</span>
                            @if(!is_null($product->cost_price))
                                Rp {{ number_format($product->cost_price, 0, ',', '.') }}
                            @else
                                -
                            @endif
                        </p>
                        <p>
                            <span class="font-medium text-gray-800">Total Stok:</span>
                            {{ $product->current_stock ?? '-' }}
                        </p>
                        <p>
                            <span class="font-medium text-gray-800">Expired Terdekat:</span>
                            {{ $product->nearest_expired_date
                                ? \Carbon\Carbon::parse($product->nearest_expired_date)->translatedFormat('d M Y')
                                : '-' }}
                        </p>
                    </div>
                </div>
            </div>
            {{-- Isi Content / Detail Batch Expired Per Item --}}
            <div>
                <h2 class="text-lg font-semibold text-gray-800 mb-3">Detail Batch Stok</h2>
                {{-- Desktop --}}
                <div class="hidden md:block overflow-x-auto border rounded">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="bg-gray-50 text-gray-700">
                            <tr>
                                <th class="p-3">Qty Awal</th>
                                <th class="p-3">Sisa</th>
                                <th class="p-3">Expired</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($product->stockIns as $stock)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3">{{ $stock->qty }}</td>
                                    <td class="p-3">
                                        <span class="{{ $stock->remaining_qty == 0 ? 'text-red-500 font-semibold' : 'text-gray-800 font-medium' }}">
                                            {{ $stock->remaining_qty }}
                                        </span>
                                    </td>
                                    <td class="p-3">
                                        {{ $stock->expired_date
                                            ? \Carbon\Carbon::parse($stock->expired_date)->translatedFormat('d M Y')
                                            : '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="p-4 text-center text-gray-500">
                                        Belum ada data stok masuk
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{-- Mobile --}}
                <div class="md:hidden space-y-3">
                    @forelse ($product->stockIns as $stock)
                        <div class="border rounded p-4 bg-gray-50">
                            <div class="grid grid-cols-1 gap-2 text-sm text-gray-600">
                                <p>
                                    <span class="font-medium text-gray-800">Qty Awal:</span>
                                    {{ $stock->qty }}
                                </p>
                                <p>
                                    <span class="font-medium text-gray-800">Sisa:</span>
                                    <span class="{{ $stock->remaining_qty == 0 ? 'text-red-500 font-semibold' : 'text-gray-800 font-medium' }}">
                                        {{ $stock->remaining_qty }}
                                    </span>
                                </p>
                                <p>
                                    <span class="font-medium text-gray-800">Expired:</span>
                                    {{ $stock->expired_date
                                        ? \Carbon\Carbon::parse($stock->expired_date)->translatedFormat('d M Y')
                                        : '-' }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm">Belum ada data stok masuk</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
