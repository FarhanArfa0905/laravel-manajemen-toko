<x-app-layout>
{{-- Header --}}
<div class="mb-4">
    <h2 class="text-xl font-bold">Data Stok Masuk</h2>
        <a href="{{ route('stock-ins.create') }}"
        class="inline-block bg-blue-500 text-white px-4 py-2 rounded">
            Tambah
        </a>
</div>
{{-- Mobile View --}}
<div class="md:hidden space-y-4">
    @forelse($stockIns as $item)
        <div class="bg-white shadow rounded-lg p-4 border">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <h3 class="font-semibold text-gray-800">
                        {{ $item->product->name }}
                    </h3>
                    <p class="text-sm text-gray-600">
                        {{ $item->product->category_label ?? $item->product->category }}
                    </p>
                </div>

                @if($item->remaining_qty > 0)
                    <span class="text-xs px-2 py-1 rounded-full bg-green-100 text-green-700">
                        Aktif
                    </span>
                @else
                    <span class="text-xs px-2 py-1 rounded-full bg-red-100 text-red-700">
                        Habis
                    </span>
                @endif
            </div>

            <div class="mt-3 text-sm text-gray-600 space-y-1">
                <p><span class="font-medium text-gray-800">Qty:</span> {{ $item->qty }}</p>
                <p><span class="font-medium text-gray-800">Sisa:</span> {{ $item->remaining_qty }}</p>
                <p><span class="font-medium text-gray-800">Expired:</span>
                    {{ $item->expired_date ? \Carbon\Carbon::parse($item->expired_date)->translatedFormat('d M Y') : '-' }}
                </p>
                <p><span class="font-medium text-gray-800">Note:</span> {{ $item->note ?? '-' }}</p>
                <p><span class="font-medium text-gray-800">Tanggal:</span>
                    {{ $item->created_at->translatedFormat('d M Y H:i') }}
                </p>
            </div>
        </div>
    @empty
        <p class="text-gray-500 text-center">Belum ada data stok masuk</p>
    @endforelse
</div>

{{-- Desktop View --}}
<div class="hidden md:block mt-4 bg-white shadow-md rounded p-6 overflow-x-auto">
    <table class="w-full text-sm text-left text-gray-600">
        <thead class="border-b bg-gray-50 text-gray-700 uppercase text-xs">
            <tr>
                <th class="px-4 py-3">Product</th>
                <th class="px-4 py-3">Tipe</th>
                <th class="px-4 py-3">Kategori</th>
                <th class="px-4 py-3">Qty</th>
                <th class="px-4 py-3">Sisa</th>
                <th class="px-4 py-3">Expired</th>
                <th class="px-4 py-3">Note</th>
                <th class="px-4 py-3">Tanggal</th>
                <th class="px-4 py-3">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($stockIns as $item)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-3 font-medium text-gray-800">
                        {{ $item->product->name }}
                    </td>
                    <td class="px-4 py-3">
                        {{ $item->product->type_label ?? ucfirst($item->product->type) }}
                    </td>
                    <td class="px-4 py-3">
                        {{ $item->product->category_label ?? $item->product->category }}
                    </td>
                    <td class="px-4 py-3">
                        {{ $item->qty }}
                    </td>
                    <td class="px-4 py-3">
                        <span class="{{ $item->remaining_qty == 0 ? 'text-red-500 font-semibold' : 'text-gray-800 font-medium' }}">
                            {{ $item->remaining_qty }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        {{ $item->expired_date ? \Carbon\Carbon::parse($item->expired_date)->translatedFormat('d M Y') : '-' }}
                    </td>
                    <td class="px-4 py-3">
                        {{ $item->note ?? '-' }}
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        {{ $item->created_at->translatedFormat('d M Y H:i') }}
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        @if($item->remaining_qty > 0)
                            <span class="text-xs px-2 py-1 rounded-full bg-green-100 text-green-700">
                                Aktif
                            </span>
                        @else
                            <span class="text-xs px-2 py-1 rounded-full bg-red-100 text-red-700">
                                Habis
                            </span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="px-4 py-6 text-center text-gray-500">
                        Belum ada data stok masuk
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
</x-app-layout>