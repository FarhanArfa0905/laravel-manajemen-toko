<x-app-layout>
    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto flex flex-col min-h-[85vh]">
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Data Stok Masuk</h1>
                <p class="text-slate-500 text-sm mt-1">Riwayat pengadaan stok barang fisik Ayra Cell.</p>
            </div>
            {{-- Button Tambah Stock --}}
            <a href="{{ route('stock-ins.create') }}"
               class="inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-6 py-2.5 rounded-xl transition shadow-lg shadow-indigo-100 group">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Stok
            </a>
        </div>
        {{-- Filter By Kategori / Search --}}
        <div class="bg-white p-4 rounded-[2rem] shadow-sm border border-slate-100 mb-6">
            <form method="GET" action="/stock-ins" class="flex flex-col md:flex-row gap-3 md:items-center">
                <select name="category" class="bg-slate-50 border-none rounded-xl text-xs font-bold text-slate-600 focus:ring-indigo-500/20 py-3 px-4">
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
                    class="bg-slate-50 border-none rounded-xl text-xs font-bold text-slate-600 focus:ring-indigo-500/20 py-3 px-4 w-full">
                <div class="flex gap-2">
                    <button class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-black uppercase tracking-widest px-6 py-3 rounded-xl transition shadow-lg shadow-indigo-100">
                        Filter
                    </button>
                    <a href="/stock-ins"
                    class="bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-black uppercase tracking-widest px-6 py-3 rounded-xl transition">
                        Reset
                    </a>
                </div>
            </form>
        </div>


        {{-- Mobile Card View --}}
        <div class="md:hidden space-y-4">
            @forelse($stockIns as $item)
                <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 p-6 relative overflow-hidden">
                    <!-- Status Indicator Line -->
                    <div class="absolute top-0 left-0 w-2 h-full {{ $item->remaining_qty > 0 ? 'bg-emerald-500' : 'bg-rose-500' }}"></div>

                    <div class="flex items-start justify-between mb-4">
                        <div class="min-w-0">
                            <h3 class="font-bold text-slate-800 text-lg truncate">{{ $item->product->name }}</h3>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $item->product->category_label ?? $item->product->category }}</p>
                        </div>
                        
                        @if($item->remaining_qty > 0)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700 uppercase tracking-tighter">
                                <span class="w-1 h-1 bg-emerald-500 rounded-full mr-1.5"></span> Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-700 uppercase tracking-tighter">
                                Habis
                            </span>
                        @endif
                    </div>
                    <div class="grid grid-cols-2 gap-4 bg-slate-50 p-4 rounded-2xl border border-slate-100">
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Qty / Sisa</p>
                            <p class="text-sm font-bold text-slate-700">{{ $item->qty }} <span class="text-slate-300 font-normal">/</span> <span class="{{ $item->remaining_qty == 0 ? 'text-rose-500' : 'text-emerald-600' }}">{{ $item->remaining_qty }}</span></p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Expired</p>
                            <p class="text-sm font-bold text-slate-700">{{ $item->expired_date ? \Carbon\Carbon::parse($item->expired_date)->format('d/m/y') : '-' }}</p>
                        </div>
                    </div>
                    <div class="mt-4 flex flex-col gap-1 text-[11px] text-slate-500">
                        <div class="flex justify-between font-medium italic">
                            <span>Note: {{ $item->note ?? '-' }}</span>
                            <span>{{ $item->created_at->format('d M, H:i') }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-10 bg-white rounded-[2rem] border border-dashed border-slate-200">
                    <p class="text-slate-400">Belum ada riwayat stok masuk</p>
                </div>
            @endforelse
        </div>

        {{-- Desktop Table View --}}
        <div class="hidden md:block bg-white shadow-sm border border-slate-100 rounded-[2.5rem] overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left border-separate border-spacing-y-0">
                    <thead>
                        <tr class="bg-slate-50/50 text-slate-500 uppercase text-[10px] tracking-widest font-bold">
                            <th class="px-6 py-5">Produk & Info</th>
                            <th class="px-6 py-5 text-center">Tipe</th>
                            <th class="px-6 py-5 text-center">Qty Awal</th>
                            <th class="px-6 py-5 text-center">Sisa</th>
                            <th class="px-6 py-5">Expired & Note</th>
                            <th class="px-6 py-5">Waktu Masuk</th>
                            <th class="px-6 py-5 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($stockIns as $item)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="min-w-0">
                                        <p class="font-bold text-slate-800">{{ $item->product->name }}</p>
                                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tight">{{ $item->product->category_label ?? $item->product->category }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-block px-2 py-1 rounded-md text-[9px] font-bold uppercase tracking-tighter border {{ $item->product->type === 'fisik' ? 'bg-amber-50 text-amber-600 border-amber-100' : 'bg-sky-50 text-sky-600 border-sky-100' }}">
                                        {{ $item->product->type_label ?? ucfirst($item->product->type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="font-bold text-slate-700">{{ $item->qty }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-3 py-1 rounded-lg font-black text-xs
                                        {{ $item->remaining_qty == 0 ? 'bg-rose-50 text-rose-500' : 'bg-emerald-50 text-emerald-600' }}">
                                        {{ $item->remaining_qty }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-[10px]">
                                        <p class="text-slate-400 font-bold">EXP: <span class="text-slate-700">{{ $item->expired_date ? \Carbon\Carbon::parse($item->expired_date)->format('d/m/y') : '-' }}</span></p>
                                        <p class="text-slate-400 italic mt-1 truncate max-w-[150px]">{{ $item->note ?? '-' }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <p class="text-xs font-bold text-slate-700">{{ $item->created_at->format('d M Y') }}</p>
                                    <p class="text-[10px] text-slate-400 font-medium tracking-tight">{{ $item->created_at->format('H:i') }} WIB</p>
                                </td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    @if($item->remaining_qty > 0)
                                        <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest bg-emerald-500 text-white shadow-sm shadow-emerald-100 italic">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest bg-slate-200 text-slate-500 italic">
                                            Habis
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-20 text-center text-slate-400 italic">
                                    Belum ada data stok masuk yang tercatat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $stockIns->links() }}
        </div>
    </div>
</x-app-layout>