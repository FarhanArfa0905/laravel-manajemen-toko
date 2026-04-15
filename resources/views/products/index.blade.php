<x-app-layout>
    <div class="max-w-5xl mx-auto mt-10 flex flex-col min-h-[85vh]">
        <h1 class="text-2xl font-bold mb-4">Product List</h1>
        <a href="/products/create"
           class="bg-blue-500 text-white px-4 py-2 rounded">
            Tambah Product
        </a>
        <div class="w-full mt-6 bg-white shadow rounded p-4 space-y-4">
            @forelse ($products as $product)
            <div class="border-b pb-4 flex flex-col md:flex-row md:justify-between md:items-center gap-3">
                <!-- Bagian Info -->
                <div class="space-y-1">
                    <h2 class="font-semibold text-gray-800">
                        {{ $product->name }}
                    </h2>
                    <p class="text-sm text-gray-600">
                        Harga: Rp {{ number_format($product->price, 0, ',', '.') }}
                    </p>
                    <p class="text-sm text-gray-600">
                        Stock: {{ $product->stock }}
                    </p>
                </div>
                <!-- Bagian Action Button -->
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