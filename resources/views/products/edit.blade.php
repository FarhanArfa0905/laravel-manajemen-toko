<x-app-layout>
    <a href="/products"
    class="inline-flex items-center gap-2 bg-white hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-md transition mb-4 shadow border">
        Kembali
    </a>
    <div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded shadow">
        <h1 class="text-xl font-bold mb-4">Edit Product</h1>
        <p class="text-sm text-gray-500 mb-5">
            Rapikan product sesuai tipe dan kategori supaya laporan stok barang fisik dan transaksi digital lebih mudah dibedakan.
        </p>
        <form id="productForm" action="/products/{{ $product->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <label class="block text-sm text-gray-600 mb-1">Nama Produk</label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full border p-2 mb-2">
            @error('name')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror

            <label class="block text-sm text-gray-600 mb-1 mt-3">Kode Product / SKU</label>
            <input type="text" name="code" value="{{ old('code', $product->code) }}" class="w-full border p-2 mb-1">
            <p class="text-xs text-gray-500 mb-2">Kalau dikosongkan, sistem akan bikin ulang kode otomatis.</p>
            @error('code')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror

            <label class="block text-sm text-gray-600 mb-1 mt-3">Tipe Product</label>
            <select name="type" id="type" class="w-full border p-2 mb-2">
                @foreach ($typeLabels as $value => $label)
                    <option value="{{ $value }}" {{ old('type', $product->type) == $value ? 'selected' : '' }}>
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

            <label class="block text-sm text-gray-500 mb-1 mt-3">Harga Jual</label>
            <input id="price" type="number" name="price" value="{{ old('price', $product->price) }}" class="w-full border p-2 mb-2">
            @error('price')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror

            <label id="costPriceLabel" class="block text-sm text-gray-500 mb-1 mt-3">Harga Modal</label>
            <input id="cost_price" type="number" name="cost_price" value="{{ old('cost_price', $product->cost_price) }}" class="w-full border p-2 mb-1">
            <p id="costPriceHelp" class="text-xs text-gray-500 mb-2"></p>
            @error('cost_price')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror

            <label class="block text-sm text-gray-600 mb-1 mt-3">Gambar Product</label>
            <input type="file" name="image" class="w-full border p-2 mb-2">
            @error('image')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
            @if ($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-20 h-20 object-cover rounded border mb-3">
            @endif

            <p id="marginText" class="text-sm font-semibold mb-3"></p>
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded w-full">
                Update
            </button>
        </form>
    </div>

    <script>
    const categoryOptions = @json($categoryOptions);
    const selectedCategory = @json(old('category', $product->category));
    const typeSelect = document.getElementById('type');
    const categorySelect = document.getElementById('category');
    const categoryHelp = document.getElementById('categoryHelp');
    const costInput = document.getElementById('cost_price');
    const costPriceLabel = document.getElementById('costPriceLabel');
    const costPriceHelp = document.getElementById('costPriceHelp');
    const priceInput = document.getElementById('price');
    const marginText = document.getElementById('marginText');
    const form = document.getElementById('productForm');

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
            categoryHelp.textContent = 'Pilih kategori barang yang benar-benar tersedia dan perlu stok.';
            costPriceLabel.textContent = 'Harga Modal';
            costInput.placeholder = 'Contoh: 12000';
            costPriceHelp.textContent = 'Wajib untuk barang fisik supaya margin dan nilai stok lebih rapi.';
        } else {
            categoryHelp.textContent = 'Pilih layanan digital seperti pulsa, token, transfer, atau pembayaran.';
            costPriceLabel.textContent = 'Modal / Saldo Keluar';
            costInput.placeholder = 'Opsional untuk digital';
            costPriceHelp.textContent = 'Boleh diisi kalau kamu mau catat biaya saldo, fee admin, atau harga beli dari aplikasi.';
        }
    }

    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID').format(number);
    }

    function calculateMargin() {
        const cost = parseFloat(costInput.value) || 0;
        const price = parseFloat(priceInput.value) || 0;
        const margin = price - cost;

        if (price === 0 && cost === 0) {
            marginText.innerHTML = '';
            return;
        }

        if (margin < 0) {
            marginText.innerHTML = `Rugi: Rp ${formatRupiah(Math.abs(margin))}`;
            marginText.classList.remove('text-green-600');
            marginText.classList.add('text-red-500');
        } else {
            marginText.innerHTML = `Untung: Rp ${formatRupiah(margin)}`;
            marginText.classList.remove('text-red-500');
            marginText.classList.add('text-green-600');
        }
    }

    typeSelect.addEventListener('change', () => {
        categorySelect.value = '';
        syncCategoryOptions();
        calculateMargin();
    });

    costInput.addEventListener('input', calculateMargin);
    priceInput.addEventListener('input', calculateMargin);

    syncCategoryOptions();
    calculateMargin();

    form.addEventListener('submit', function(e) {
        const cost = parseFloat(costInput.value) || 0;
        const price = parseFloat(priceInput.value) || 0;
        const type = typeSelect.value;

        if (type === 'fisik' && price < cost) {
            e.preventDefault();

            Swal.fire({
                icon: 'error',
                title: 'Harga Tidak Valid',
                text: 'Harga jual tidak boleh lebih kecil dari harga modal untuk produk fisik.',
            });
        }
    });
    </script>
</x-app-layout>
