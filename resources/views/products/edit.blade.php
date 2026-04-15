<x-app-layout>
    <a href="/products"
    class="inline-flex items-center gap-2 bg-white hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-md transition mb-4 shadow border">
        ← Kembali
    </a>
    <div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded shadow">
        <h1 class="text-xl font-bold mb-4">Edit Product</h1>
        <form id="productForm" action="/products/{{ $product->id }}" method="POST">
            @csrf
            @method('PUT')
            {{-- Form Nama Produk --}}
                <label class="block text-sm text-gray-600 mb-1">Nama Produk</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full border p-2 mb-2">
                @error('name')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            {{-- Form Harga Jual Produk --}}
                <label class="block text-sm text-gray-500 mb-1">Harga Jual</label>
                <input id="price" type="number" name="price" value="{{ old('price', $product->price) }}" class="w-full border p-2 mb-2">
                @error('price')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            {{-- Form Harga Modal --}}
                <label class="block text-sm text-gray-500 mb-1">Harga Modal</label>
                <input id="cost_price" type="number" name="cost_price" value="{{ old('cost_price', $product->cost_price) }}" class="w-full border p-2 mb-2">
                @error('cost_price')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            {{-- Selisih Harga Jual dan Harga Modal --}}
                <p id="marginText" class="text-sm font-semibold mb-1"></p>
            {{-- Button Update --}}
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded w-full">
                Update
            </button>
        </form>
    </div>

    <!-- Script JS Hitung Keuntungan dan Kerugian -->
    <script>
    const costInput = document.getElementById('cost_price');
    const priceInput = document.getElementById('price');
    const marginText = document.getElementById('marginText');
    const form = document.getElementById('productForm');

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

    //Realtime Update Margin atau Keuntungan/Kerugian Cost-Price
    costInput.addEventListener('input', calculateMargin);
    priceInput.addEventListener('input', calculateMargin);

    //Jalankan Fungsi Calculated Penghitungan Ketugian
    calculateMargin();

    //Modal Buat Mengisi Agar Harga JUal Lebih Tinggi
    form.addEventListener('submit', function(e) {
        const cost = parseFloat(costInput.value) || 0;
        const price = parseFloat(priceInput.value) || 0;

        if (price < cost) {
            e.preventDefault();

            Swal.fire({
                icon: 'error',
                title: 'Harga Tidak Valid',
                text: 'Harga jual tidak boleh lebih kecil dari harga modal!',
            });
        }
    });
    </script>
</x-app-layout>