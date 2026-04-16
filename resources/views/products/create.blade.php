<x-app-layout>
    <a href="/products" type="button" onclick="handleCheckout(this)"
    class="inline-flex items-center gap-2 bg-white hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-md transition mb-4 shadow border">
        Kembali
    </a>
    <div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded shadow">
        <h1 class="text-xl font-bold mb-4">Tambah Product</h1>
        <p class="text-sm text-gray-500 mb-5">
            Produk fisik cocok untuk stok barang seperti voucher, charger, atau kabel data.
            Produk digital cocok untuk pulsa, token listrik, transfer, dan layanan pembayaran.
        </p>
        <form action="/products" method="POST" enctype="multipart/form-data" id="productForm">
            @csrf
            <label class="block text-sm text-gray-600 mb-1">Nama Product</label>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama Product" class="w-full border p-2 mb-2">
            @error('name')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror

            <label class="block text-sm text-gray-600 mb-1 mt-3">Kode Product / SKU</label>
            <input type="text" name="code" value="{{ old('code') }}" placeholder="Kosongkan jika ingin dibuat otomatis" class="w-full border p-2 mb-1">
            <p class="text-xs text-gray-500 mb-2">Contoh otomatis: `FSK-KAR-150426-123` atau `DGT-PUL-150426-123`.</p>
            @error('code')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror

            <label class="block text-sm text-gray-600 mb-1 mt-3">Tipe Product</label>
            <select name="type" id="type" class="w-full border p-2 mb-2">
                @foreach ($typeLabels as $value => $label)
                    <option value="{{ $value }}" {{ old('type', \App\Models\Product::TYPE_FISIK) == $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            @error('type')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror

            <label class="block text-sm text-gray-600 mb-1 mt-3">Kategori</label>
            <select name="category" id="category" class="w-full border p-2 mb-1"></select>
            <p id="categoryHelp" class="text-xs text-gray-500 mb-2"></p>
            @error('category')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror

            <label class="block text-sm text-gray-600 mb-1 mt-3">Harga Jual</label>
            <input type="number" name="price" value="{{ old('price') }}" placeholder="Harga" class="w-full border p-2 mb-2">
            @error('price')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror

            <label class="block text-sm text-gray-600 mb-1 mt-3" id="costPriceLabel">Harga Modal</label>
            <input type="number" name="cost_price" id="cost_price" value="{{ old('cost_price') }}" placeholder="Modal" class="w-full border p-2 mb-1">
            <p id="costPriceHelp" class="text-xs text-gray-500 mb-2"></p>
            @error('cost_price')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror

            <label class="block text-sm text-gray-600 mb-1 mt-3">Gambar Product</label>
            <input type="file" name="image" class="mb-2">
            @error('image')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
            <button class="bg-blue-500 text-white px-4 py-2 rounded w-full">
                Simpan
            </button>
        </form>
    </div>

    <script>
        const categoryOptions = @json($categoryOptions);
        const selectedCategory = @json(old('category'));
        const typeSelect = document.getElementById('type');
        const categorySelect = document.getElementById('category');
        const categoryHelp = document.getElementById('categoryHelp');
        const costPriceInput = document.getElementById('cost_price');
        const costPriceLabel = document.getElementById('costPriceLabel');
        const costPriceHelp = document.getElementById('costPriceHelp');

        function syncCategoryOptions() {
            const type = typeSelect.value;
            const categories = categoryOptions[type] || {};
            const currentValue = categorySelect.value || selectedCategory;

            categorySelect.innerHTML = '<option value="">Pilih kategori</option>';

            Object.entries(categories).forEach(([value, label]) => {
                const option = document.createElement('option');
                option.value = value;
                option.textContent = label;

                if (currentValue === value) {
                    option.selected = true;
                }

                categorySelect.appendChild(option);
            });

            if (type === 'fisik') {
                categoryHelp.textContent = 'Pilih barang yang benar-benar punya stok fisik di toko.';
                costPriceLabel.textContent = 'Harga Modal';
                costPriceInput.placeholder = 'Contoh: 12000';
                costPriceHelp.textContent = 'Wajib diisi untuk produk fisik agar untung-rugi lebih mudah dipantau.';
            } else {
                categoryHelp.textContent = 'Pilih layanan digital yang memakai saldo aplikasi atau fee transaksi.';
                costPriceLabel.textContent = 'Modal / Saldo Keluar';
                costPriceInput.placeholder = 'Opsional untuk digital';
                costPriceHelp.textContent = 'Untuk produk digital bisa diisi jika kamu ingin melacak biaya saldo atau harga beli dari aplikasi.';
            }
        }

        typeSelect.addEventListener('change', () => {
            categorySelect.value = '';
            syncCategoryOptions();
        });

        syncCategoryOptions();
    </script>
</x-app-layout>
