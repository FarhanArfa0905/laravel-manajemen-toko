<x-app-layout>
    <a href="/products" type="button" onclick="handleCheckout(this)"
    class="inline-flex items-center gap-2 bg-white hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-md transition mb-4 shadow border">
        Kembali
    </a>
    <div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded shadow">
        <h1 class="text-xl font-bold mb-4">Tambah Product</h1>
        {{-- Content Form Pengisian Data Product --}}
        <form action="/products" method="POST">
            @csrf
            <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama Product" class="w-full border p-2 mb-2">
            @error('name')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
            <input type="number" name="price" value="{{ old('price') }}" placeholder="Harga" class="w-full border p-2 mb-2">
            @error('price')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
            <input type="number" name="cost_price" value="{{ old('cost_price') }}" placeholder="Modal" class="w-full border p-2 mb-2">
            @error('cost_price')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
            <button class="bg-blue-500 text-white px-4 py-2 rounded w-full">
                Simpan
            </button>
        </form>
    </div>
</x-app-layout>