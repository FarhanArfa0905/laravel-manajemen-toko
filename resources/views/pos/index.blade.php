<x-app-layout>
    {{-- Back Button --}}
    <a href="/dashboard"
    class="inline-flex items-center gap-2 bg-white hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-md transition mb-4 shadow border">
        ← Kembali
    </a>
    {{-- Content Input Harga --}}
    <div class="bg-white p-6 rounded shadow">
        {{-- <h1 class="text-xl font-bold mb-4">Tambah Product</h1> --}}
        <h1 class="text-xl font-bold mb-4">Filter Product</h1>
        {{-- Form Filter --}}
        <form method="GET" action="/pos" class="space-y-3">
        <select name="type" class="w-full border p-2 rounded" id="type">
            <option value="">Semua Tipe</option>
            @foreach ($typeLabels as $value => $label)
                <option value="{{ $value }}" {{ $selectedType == $value ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>

        <select name="category" class="w-full border p-2 rounded" id="category">
            <option value="">Semua Kategori</option>
                @foreach ($filteredCategories as $value => $label)
                    <option value="{{ $value }}" {{ $selectedCategory == $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
        </select>

        <select name="provider" class="w-full border p-2 rounded">
            <option value="">Semua Provider</option>
            @foreach ($providers as $provider)
                <option value="{{ $provider }}" {{ $selectedProvider == $provider ? 'selected' : '' }}>
                    {{ $provider }}
                </option>
            @endforeach
        </select>

        <input
            type="text"
            name="search"
            value="{{ $search }}"
            placeholder="Cari nama product"
            class="w-full border p-2 rounded"
        >

        <div class="flex gap-2">
            <button class="bg-blue-500 text-white px-4 py-2 rounded">
                Filter
            </button>
            <a href="/pos" class="bg-gray-300 text-gray-800 px-4 py-2 rounded">
                Reset
            </a>
        </div>
    </form>
    {{-- Form Nambahkan Barang ke Cart --}}
<div class="mt-6">
    <h2 class="text-lg font-semibold mb-3">Hasil Product</h2>

    <div class="space-y-3">
        @forelse ($products as $product)
            <div class="border rounded p-4 bg-gray-50">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                    {{-- <div>
                        <h3 class="font-semibold text-gray-800">{{ $product->name }}</h3>
                        <p class="text-sm text-gray-600">
                            {{ $product->type_label }} • {{ $product->category_label }}
                        </p>
                        <p class="text-sm text-gray-600">
                            Provider: {{ $product->provider ?? '-' }}
                        </p>
                        <p class="text-sm text-gray-600">
                            Harga: Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>
                        <p class="text-sm text-gray-600">
                            Stok: {{ $product->current_stock ?? '-' }}
                        </p>
                    </div> --}}
                    <div>
                        <h3 class="font-semibold text-gray-800">{{ $product->name }}</h3>
                        <p class="text-sm text-gray-600">
                            {{ $product->type_label }} • {{ $product->category_label }}
                        </p>
                        <p class="text-sm text-gray-600">
                            Provider: {{ $product->provider ?? '-' }}
                        </p>
                        <p class="text-sm text-gray-600">
                            Kode: {{ $product->code ?? '-' }}
                        </p>
                        <p class="text-sm text-gray-600">
                            Harga: Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>
                        <p class="text-sm text-gray-600">
                            Stok: {{ $product->current_stock ?? '-' }}
                        </p>
                    </div>


                    <form method="POST" action="/pos/add" class="flex items-center gap-2">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="number" name="qty" value="1" min="1" class="w-20 border rounded p-2">
                        <button class="bg-blue-500 text-white px-4 py-2 rounded">
                            Tambah
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-sm text-gray-500">Belum ada product yang cocok dengan filter.</p>
        @endforelse
    </div>
</div>

    </div>
    {{-- Cart Catalog Penjualan--}}
    <div class="bg-white shadow rounded p-4">
        <h2 class="text-lg font-semibold mb-3">Cart</h2>
        <table class="w-full">
            <thead>
                <tr class="text-left border-b">
                    <th class="p-2">Produk</th>
                    <th class="p-2">Harga</th>
                    <th class="p-2">Qty</th>
                    <th class="p-2">Subtotal</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach ($cart as $item)
                    @php
                        $subtotal = $item['price'] * $item['qty'];
                        $total += $subtotal;
                    @endphp
                    <tr class="border-b">
                        <td class="p-2">{{ $item['name'] }}</td>
                        <td class="p-2">Rp {{ number_format($item['price']) }}</td>
                        <td class="p-2">{{ $item['qty'] }}</td>
                        <td class="p-2">Rp {{ number_format($subtotal) }}</td>
                        <td class="p-2">
                            <form method="POST" action="/pos/remove">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $item['product_id'] }}">
                                <button class="text-red-500 text-sm">✕</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="text-right mt-4 font-bold text-lg">
            Total: Rp {{ number_format($total) }}
        </div>
        @if(empty($cart))
        <tr>
            <td colspan="5" class="text-center justify-items-center text-gray-400 py-6">
                Cart masih kosong
            </td>
        </tr>
        @endif
    </div>
    {{-- Action Button Clear & Checkout --}}
    <div class="flex justify-end mt-4 gap-2">
        <form method="POST" action="/pos/clear">
            @csrf
            <button class="bg-gray-400 text-white px-4 py-2 rounded">
                Clear Cart
            </button>
        </form>
        <form id="checkoutForm" action="/pos/checkout" method="POST">
            @csrf
            <button type="button"
                onclick="openModal()"
                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                Checkout
            </button>
        </form>
    </div>
    {{-- Modal --}}
    <div id="checkoutModal"
        class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50"
        onclick="closeModal()">
        <div class="bg-white rounded-lg p-6 w-96 shadow-lg"
            onclick="event.stopPropagation()">
            <h2 class="text-lg font-semibold mb-4">
                Konfirmasi Checkout
            </h2>
            <p class="mb-6">
                Yakin mau lanjut checkout?
            </p>
            <div class="flex justify-end gap-2">
                <button onclick="closeModal()"
                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                    Batal
                </button>
                <button type="button" onclick="submitCheckout()"
                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Ya, Checkout
                </button>
            </div>
        </div>
    </div>

    {{-- Script JS --}}
    <script>
        function openModal() {
            const modal = document.getElementById('checkoutModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
        function closeModal() {
            const modal = document.getElementById('checkoutModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
        function submitCheckout() {
            document.getElementById('checkoutForm').submit();
        }
    </script>

    <script>
        const categoryOptions = @json($categoryOptions);
        const selectedType = @json($selectedType);
        const selectedCategory = @json($selectedCategory);

        const typeSelect = document.getElementById('type');
        const categorySelect = document.getElementById('category');

        function renderCategories(typeValue) {
            const categories = categoryOptions[typeValue] || {};

            categorySelect.innerHTML = '<option value="">Semua Kategori</option>';

            Object.entries(categories).forEach(([value, label]) => {
                const option = document.createElement('option');
                option.value = value;
                option.textContent = label;

                if (selectedCategory === value) {
                    option.selected = true;
                }

                categorySelect.appendChild(option);
            });
        }

        typeSelect.addEventListener('change', function () {
            renderCategories(this.value);
        });

        renderCategories(typeSelect.value);
    </script>

</x-app-layout>