<x-app-layout>
    <div class="max-w-7xl mx-auto mt-10 flex flex-col min-h-[85vh]">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4">
            <div>
                <h1 class="text-2xl font-bold">Product List</h1>
                <p class="text-sm text-gray-500 mt-1">
                    Daftar produk fisik dan digital.
                </p>
            </div>
            
            <a href="/products/create"
               class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded w-fit">
                Tambah Product
            </a>
        </div>

        {{-- Mobile Card View --}}
        <div class="md:hidden space-y-4">
            @forelse ($products as $product)
                <div class="bg-white rounded-lg shadow p-4 border">
                    <div class="flex gap-3">
                        <div class="w-16 h-16 rounded border overflow-hidden bg-gray-100 flex items-center justify-center shrink-0">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-[10px] text-gray-400 text-center px-1">No Image</span>
                            @endif
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-2">
                                <h2 class="font-semibold text-gray-800 leading-tight">
                                    {{ $product->name }}
                                </h2>

                                <span class="text-[10px] px-2 py-1 rounded-full whitespace-nowrap
                                    {{ $product->type === \App\Models\Product::TYPE_FISIK ? 'bg-amber-100 text-amber-700' : 'bg-sky-100 text-sky-700' }}">
                                    {{ $product->type_label ?? ucfirst($product->type) }}
                                </span>
                            </div>

                            <div class="mt-2 text-sm text-gray-600 space-y-1">
                                <p>Kategori: {{ $product->category_label ?? $product->category }}</p>
                                <p>Provider: {{ $product->provider ?? '-' }}</p>
                                <p>Kode: {{ $product->code ?? '-' }}</p>
                                <p>Harga Modal:
                                    @if(!is_null($product->cost_price))
                                        Rp {{ number_format($product->cost_price, 0, ',', '.') }}
                                    @else
                                        -
                                    @endif
                                </p>
                                <p>Harga Jual: Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                <p>Stok:
                                    {{-- @if($product->type === \App\Models\Product::TYPE_FISIK)
                                        {{ $product->current_stock }}
                                    @else
                                        -
                                    @endif --}}
                                    <span class="font-medium text-gray-800">{{ $product->current_stock ?? '-' }}</span>
                                </p>
                                <p>Expired:
                                    <span class="font-medium text-gray-800">
                                        {{ $product->nearest_expired_date
                                            ? \Carbon\Carbon::parse($product->nearest_expired_date)->translatedFormat('d M Y')
                                            : '-' }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 flex flex-wrap gap-2">
                        <a href="/products/{{ $product->id }}/edit"
                           class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-2 rounded text-xs">
                            Edit
                        </a>
                        <a href="/products/{{ $product->id }}"
                           class="bg-blue-400 hover:bg-blue-500 text-white px-3 py-2 rounded text-xs">
                            Detail
                        </a>
                        <form id="delete-mobile-{{ $product->id }}" action="/products/{{ $product->id }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button"
                                onclick="confirmDelete({{ $product->id }})"
                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded text-xs">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-center">Belum ada produk</p>
            @endforelse
        </div>

        {{-- Desktop Table View --}}
        <div class="hidden md:block bg-white shadow rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="bg-gray-50 text-gray-700 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3">Foto</th>
                            <th class="px-4 py-3">Nama</th>
                            <th class="px-4 py-3">Tipe</th>
                            <th class="px-4 py-3">Kategori</th>
                            <th class="px-4 py-3">Provider</th>
                            <th class="px-4 py-3">Harga Modal</th>
                            <th class="px-4 py-3">Harga Jual</th>
                            <th class="px-4 py-3">Stok</th>
                            <th class="px-4 py-3">Expired</th>
                            <th class="px-4 py-3">Kode</th>
                            <th class="px-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($products as $product)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <div class="w-14 h-14 rounded border overflow-hidden bg-gray-100 flex items-center justify-center">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}"
                                                 alt="{{ $product->name }}"
                                                 class="w-full h-full object-cover">
                                        @else
                                            <span class="text-[10px] text-gray-400">No Image</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3 font-medium text-gray-800 whitespace-nowrap">
                                    {{ $product->name }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="text-xs px-2 py-1 rounded-full
                                        {{ $product->type === \App\Models\Product::TYPE_FISIK ? 'bg-amber-100 text-amber-700' : 'bg-sky-100 text-sky-700' }}">
                                        {{ $product->type_label ?? ucfirst($product->type) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    {{ $product->category_label ?? $product->category }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    {{ $product->provider ?? '-' }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    @if(!is_null($product->cost_price))
                                        Rp {{ number_format($product->cost_price, 0, ',', '.') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="font-medium text-gray-800">{{ $product->current_stock ?? '-' }}</span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="font-medium text-gray-800">
                                        {{ $product->nearest_expired_date
                                            ? \Carbon\Carbon::parse($product->nearest_expired_date)->translatedFormat('d M Y')
                                            : '-' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    {{ $product->code ?? '-' }}
                                </td>

                                <td class="px-4 py-3">
                                    <div class="flex flex-wrap items-center gap-2 min-w-max">
                                        <div class="flex flex-wrap items-center gap-2 min-w-max">
                                            <a href="/products/{{ $product->id }}/edit"
                                                class="inline-flex items-center justify-center min-w-[72px] px-3 py-2 rounded text-xs font-medium bg-yellow-400 hover:bg-yellow-500 text-white">
                                                  Edit
                                            </a>
                                            <a href="/products/{{ $product->id }}"
                                                class="inline-flex items-center justify-center min-w-[72px] px-3 py-2 rounded text-xs font-medium bg-blue-400 hover:bg-blue-500 text-white">
                                                    Detail
                                            </a>
                                            <form id="delete-{{ $product->id }}" action="/products/{{ $product->id }}" method="POST" class="m-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    onclick="confirmDelete({{ $product->id }})"
                                                        class="inline-flex items-center justify-center min-w-[72px] px-3 py-2 rounded text-xs font-medium bg-red-500 hover:bg-red-600 text-white">
                                                        Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="px-4 py-6 text-center text-gray-500">
                                    Belum ada produk
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            {{ $products->links() }}
        </div>
    </div>
</x-app-layout>
