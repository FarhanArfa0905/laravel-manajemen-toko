<x-app-layout>

<div class="max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">Stok Keluar</h1>

    <form action="/stock-outs" method="POST" class="space-y-4">
        @csrf

        {{-- Product --}}
        <div>
            <label>Product</label>
            <select name="product_id" class="w-full border rounded p-2">
                @foreach ($products as $product)
                    <option value="{{ $product->id }}">
                        {{ $product->name }} (Stock: {{ $product->stock }})
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Qty --}}
        <div>
            <label>Qty</label>
            <input type="number" name="qty" class="w-full border rounded p-2">
        </div>

        {{-- Note --}}
        <div>
            <label>Note</label>
            <textarea name="note" class="w-full border rounded p-2"></textarea>
        </div>

        <button class="bg-red-500 text-white px-4 py-2 rounded">
            Simpan
        </button>
    </form>
</div>

</x-app-layout>