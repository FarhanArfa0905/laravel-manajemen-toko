<x-app-layout>
    <div class="max-w-5xl mx-auto mt-10 flex flex-col min-h-[85vh]">
        <h1 class="text-2xl font-bold mb-4">Product List</h1>
        <p class="text-sm text-gray-500">
            Pisahkan produk fisik dan digital supaya stok, modal, dan layanan konter lebih gampang dipantau.
        </p>
        <div class="mt-4">
            <a href="/products/create"
               class="bg-blue-500 text-white px-4 py-2 rounded">
                Tambah Product
            </a>
        </div>
        <div class="w-full mt-6 bg-white shadow rounded p-4 space-y-4">
            @forelse ($products as $product)
            <div class="border-b pb-4 flex flex-col md:flex-row md:justify-between md:items-start gap-4">
                <div class="flex gap-4">
                    <div class="w-20 h-20 rounded border bg-gray-50 overflow-hidden flex items-center justify-center shrink-0">
                        @if($product->image)
                            <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-xs text-gray-400 text-center px-2">No Image</span>
                        @endif
                    </div>
                    <div class="space-y-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <h2 class="font-semibold text-gray-800">
                                {{ $product->name }}
                            </h2>
                            <span class="text-xs px-2 py-1 rounded-full {{ $product->type === \App\Models\Product::TYPE_FISIK ? 'bg-amber-100 text-amber-700' : 'bg-sky-100 text-sky-700' }}">
                                {{ $product->type_label }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-600">
                            Kode: <span class="font-medium text-gray-800">{{ $product->code ?? '-' }}</span>
                        </p>
                        <p class="text-sm text-gray-600">
                            Kategori: <span class="font-medium text-gray-800">{{ $product->category_label }}</span>
                        </p>
                        <p class="text-sm text-gray-600">
                            Harga Jual: Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>
                        <p class="text-sm text-gray-600">
                            Harga Modal:
                            @if(! is_null($product->cost_price))
                                Rp {{ number_format($product->cost_price, 0, ',', '.') }}
                            @else
                                <span class="text-gray-400">Belum diisi</span>
                            @endif
                        </p>
                        <p class="text-sm text-gray-600">
                            Stock:
                            @if(! is_null($product->stock))
                                {{ $product->stock }}
                            @else
                                <span class="text-gray-400">{{ $product->type === \App\Models\Product::TYPE_FISIK ? 'Belum ada stok' : 'Tidak dipakai di produk digital' }}</span>
                            @endif
                        </p>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row gap-2 sm:items-center">
                    <a href="/products/{{ $product->id }}/edit"
                    class="bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-2 rounded text-sm sm:text-base text-center">
                        Edit
                    </a>
                    <a href="/products/{{ $product->id }}"
                    class="bg-blue-400 hover:bg-blue-500 text-white px-4 py-2 rounded text-sm sm:text-base text-center">
                        Detail
                    </a>
                    <form id="delete-{{ $product->id }}" action="/products/{{ $product->id }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button"
                            onclick="confirmDelete({{ $product->id }})"
                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded text-sm sm:text-base w-full sm:w-auto">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <p class="text-gray-500">Belum ada produk</p>
            @endforelse
        </div>
        <div class="mt-auto pt-6">
            {{ $products->links() }}
        </div>
    </div>
</x-app-layout>
