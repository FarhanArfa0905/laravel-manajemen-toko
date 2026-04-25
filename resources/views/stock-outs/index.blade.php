<x-app-layout>
    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto flex flex-col min-h-[90vh]">
        
        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight italic uppercase">Stok Keluar Manual</h1>
                <p class="text-slate-500 text-sm mt-1 font-medium">
                    Pencatatan barang fisik yang keluar di luar transaksi penjualan (Rusak, Expired, dll).
                </p>
            </div>

            <a href="/stock-outs/create"
               class="inline-flex items-center justify-center bg-rose-500 hover:bg-rose-600 text-white font-black px-6 py-3 rounded-2xl transition shadow-lg shadow-rose-100 group uppercase tracking-widest text-xs">
                <svg class="w-5 h-5 mr-2 group-hover:rotate-45 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Catat Stok Keluar
            </a>
        </div>
        
        {{-- Filter By Kategori --}}
        <div class="bg-white p-4 rounded-[2rem] shadow-sm border border-slate-100 mb-6">
            <form method="GET" action="/stock-outs" class="flex flex-col md:flex-row gap-3 md:items-center">
                <select name="category" class="bg-slate-50 border-none rounded-xl text-xs font-bold text-slate-600 focus:ring-rose-500/20 py-3 px-4">
                    <option value="">Semua Kategori</option>
                    @foreach ($categoryOptions as $value => $label)
                        <option value="{{ $value }}" {{ $selectedCategory == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>

                <input type="text"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Cari nama produk..."
                    class="bg-slate-50 border-none rounded-xl text-xs font-bold text-slate-600 focus:ring-rose-500/20 py-3 px-4 w-full">

                <div class="flex gap-2">
                    <button class="bg-rose-500 hover:bg-rose-600 text-white text-xs font-black uppercase tracking-widest px-6 py-3 rounded-xl transition shadow-lg shadow-rose-100">
                        Filter
                    </button>

                    <a href="/stock-outs"
                    class="bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-black uppercase tracking-widest px-6 py-3 rounded-xl transition">
                        Reset
                    </a>
                </div>
            </form>
        </div>


        {{-- Desktop View --}}
        <div class="hidden md:block bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left border-separate border-spacing-0">
                    <thead>
                        <tr class="bg-slate-50/50 text-slate-500 uppercase text-[10px] tracking-[0.2em] font-black">
                            <th class="px-8 py-5">Produk & SKU</th>
                            <th class="px-8 py-5">Kategori</th>
                            <th class="px-8 py-5 text-center">Jumlah Keluar</th>
                            <th class="px-8 py-5">Alasan / Catatan</th>
                            <th class="px-8 py-5">Waktu Eksekusi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse ($stockOuts as $item)
                            <tr class="hover:bg-rose-50/30 transition-colors group">
                                <td class="px-8 py-5">
                                    <div class="flex flex-col">
                                        <span class="font-black text-slate-800 text-base leading-tight group-hover:text-rose-600 transition-colors italic">
                                            {{ $item->product->name }}
                                        </span>
                                        <span class="text-[10px] font-bold text-slate-400 mt-1 uppercase tracking-widest">
                                            {{ $item->product->code ?? 'N/A' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <span class="px-3 py-1 rounded-lg bg-slate-100 text-slate-600 text-[10px] font-black uppercase tracking-tighter">
                                        {{ $item->product->category_label ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-center">
                                    <div class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-rose-50 text-rose-600 font-black text-sm border border-rose-100">
                                        -{{ $item->qty }}
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <p class="text-slate-500 font-medium italic text-xs leading-relaxed max-w-xs">
                                        {{ $item->note ?? 'Tidak ada catatan' }}
                                    </p>
                                </td>
                                <td class="px-8 py-5 whitespace-nowrap">
                                    <p class="text-xs font-bold text-slate-700 tracking-tight">
                                        {{ $item->created_at->translatedFormat('d M Y') }}
                                    </p>
                                    <p class="text-[10px] text-slate-400 font-medium uppercase tracking-tighter mt-0.5">
                                        Pukul {{ $item->created_at->format('H:i') }} WIB
                                    </p>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-20 text-center">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-16 h-16 text-slate-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                        <p class="text-slate-400 font-bold uppercase tracking-[0.2em] text-[10px]">Belum ada data stok keluar manual</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Mobile Card View --}}
        <div class="md:hidden space-y-4">
            @forelse ($stockOuts as $item)
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-6 relative overflow-hidden group">
                    <!-- Rose Accent Line -->
                    <div class="absolute top-0 left-0 w-2 h-full bg-rose-500 opacity-20"></div>

                    <div class="flex items-start justify-between gap-4 mb-4">
                        <div class="min-w-0">
                            <h3 class="font-black text-slate-800 text-lg leading-tight truncate italic">
                                {{ $item->product->name }}
                            </h3>
                            <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest mt-1">
                                {{ $item->product->category_label ?? '-' }}
                            </p>
                        </div>

                        <div class="bg-rose-500 text-white px-3 py-1.5 rounded-xl font-black text-sm shadow-lg shadow-rose-100">
                            -{{ $item->qty }}
                        </div>
                    </div>

                    <div class="bg-slate-50 p-4 rounded-2xl space-y-3">
                        <div class="flex flex-col">
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest italic">Alasan:</span>
                            <span class="text-xs font-semibold text-slate-600 mt-1">{{ $item->note ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between items-center pt-2 border-t border-slate-100">
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest italic">Waktu:</span>
                            <span class="text-[10px] font-bold text-slate-700 uppercase tracking-tighter">
                                {{ $item->created_at->translatedFormat('d M Y, H:i') }}
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-10 text-center">
                    <p class="text-slate-400 font-bold uppercase tracking-widest text-[10px] opacity-60 italic">Data masih kosong</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $stockOuts->links() }}
        </div>
    </div>
</x-app-layout>