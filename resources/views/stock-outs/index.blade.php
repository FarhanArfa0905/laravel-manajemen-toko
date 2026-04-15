<x-app-layout>
    {{-- Content Halaman Utama Barang Keluar --}}
    <div class="max-w-5xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">Data Stok Keluar</h1>
        <a href="/stock-outs/create"
        class="bg-blue-500 text-white px-4 py-2 rounded">
            Tambah
        </a>
        <div class="mt-6 bg-white shadow rounded p-4">
            <table class="w-full">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stockOuts as $item)
                    <tr class="border-t hover:bg-gray-50 transition">
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>{{ $item->created_at }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>