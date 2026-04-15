<x-app-layout>
    <div class="max-w-xl mx-auto">
        <h2 class="text-xl font-bold mb-4">Tambah Stok Masuk</h2>
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
            </div>
            <div>
                <label>Qty</label>
                <input type="number" name="qty" class="w-full border p-2 rounded">
            </div>
            <div>
                <label>Expired Date</label>
                <input type="date" name="expired_date" class="w-full border p-2 rounded">
            </div>
            <div>
                <label>Note</label>
                <textarea name="note" class="w-full border p-2 rounded"></textarea>
            </div>
            <button class="bg-green-500 text-white px-4 py-2 rounded">
                Simpan
            </button>
        </form>
    </div>
</x-app-layout>