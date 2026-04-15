<x-app-layout>
    {{-- Back Button --}}
    <a href="/products"
    class="inline-flex items-center gap-2 bg-white hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-md transition mb-4 shadow border">
        ← Kembali
    </a>
    {{-- Content Input Harga --}}
    <div class="bg-white p-6 rounded shadow">
        <h1 class="text-xl font-bold mb-4">Tambah Product</h1>
        <form method="POST" action="/pos/add">
            @csrf
            <select name="product_id" class="w-full border p-2 mb-2">
                @foreach ($products as $product)
                    <option value="{{ $product->id }}">
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>
            <input type="number" name="qty" placeholder="Qty" class="w-full border p-2 mb-2">
            <button class="bg-blue-500 text-white px-4 py-2 rounded w-full">
                Tambah
            </button>
        </form>
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
</x-app-layout>