<x-app-layout>
    <div class="max-w-xl mx-auto">
        <h2 class="text-xl font-bold mb-4">Tambah Stok Masuk</h2>
        {{-- Validasi Error Cek Data Buat Valid --}}
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 p-3 rounded">
                <p class="font-medium">Ada data yang belum valid.</p>
            </div>
        @endif
        {{-- Content Form Create Barang Masuk --}}
        <form action="{{ route('stock-ins.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label>Product</label>
                <select name="product_id" class="w-full border p-2 rounded">
                    <option value="">-- pilih --</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">
                            {{ $product->name }}
                        </option>
                    @endforeach
                </select>
                @error('product_id')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label>Qty</label>
                <input type="number" name="qty" class="w-full border p-2 rounded">
                @error('qty')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label>Expired Date</label>
                <input type="date" name="expired_date" class="w-full border p-2 rounded">
                <p class="text-xs text-gray-500 mb-2">Expired Untuk Produk Fisik Apabila Ada.</p>
                @error('expired_date')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label>Note</label>
                <textarea name="note" class="w-full border p-2 rounded"></textarea>
                <p class="text-xs text-gray-500 mb-2">Catatan Misalkan Supplier, Dll</p>
                @error('note')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <button class="bg-green-500 text-white px-4 py-2 rounded">
                Simpan
            </button>
        </form>
    </div>
</x-app-layout>