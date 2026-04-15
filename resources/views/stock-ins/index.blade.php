<x-app-layout>
    {{-- Content Halaman Utama Stock Masuk --}}
    <div class="max-w-5xl mx-auto">
        <h2 class="text-xl font-bold mb-4">Data Stok Masuk</h2>
        <a href="{{ route('stock-ins.create') }}"
        class="bg-blue-500 text-white px-4 py-2 rounded">
            Tambah
        </a>
        <div class="mt-4 bg-white shadow-md rounded p-6">
            <table class="w-full">
                <tr class="border-b hover:bg-gray-50 transition">
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Sisa</th>
                    <th>Expired</th>
                    <th>Tanggal</th>
                </tr>
                @foreach($stockIns as $item)
                <tr class="border-b hover:bg-gray-50 transition">
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>{{ $item->remaining_qty }}</td>
                    <td>{{ $item->expired_date }}</td>
                    <td>{{ $item->created_at }}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</x-app-layout>