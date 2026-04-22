<x-app-layout>
    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto flex flex-col min-h-[85vh]">
        
        <!-- Breadcrumb / Back Button -->
        <div class="mb-6">
            <a href="/products" class="inline-flex items-center text-sm font-semibold text-slate-500 hover:text-indigo-600 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Daftar Produk
            </a>
        </div>

        <div class="bg-white shadow-sm border border-slate-100 rounded-[2.5rem] overflow-hidden">
            <!-- Bagian Atas: Info Utama -->
            <div class="p-8 md:p-12 border-b border-slate-50">
                <div class="flex flex-col md:flex-row gap-10">
                    
                    {{-- Image Section --}}
                    <div class="w-full md:w-64 shrink-0">
                        <div class="aspect-square bg-slate-50 rounded-[2rem] border border-slate-100 overflow-hidden flex items-center justify-center shadow-inner">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="text-center px-4">
                                    <svg class="w-12 h-12 text-slate-200 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span class="text-xs font-bold text-slate-300 uppercase tracking-widest">No Image</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Text Info Section --}}
                    <div class="flex-1">
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                            <div>
                                <span class="inline-block px-3 py-1 rounded-lg text-[10px] font-bold uppercase tracking-widest mb-3
                                    {{ $product->type === \App\Models\Product::TYPE_FISIK ? 'bg-amber-100 text-amber-600' : 'bg-sky-100 text-sky-600' }}">
                                    {{ $product->type_label }}
                                </span>
                                <h1 class="text-3xl md:text-4xl font-extrabold text-slate-800 tracking-tight leading-tight">
                                    {{ $product->name }}
                                </h1>
                                <p class="text-slate-400 font-medium mt-1 uppercase tracking-tighter">{{ $product->category_label }} • {{ $product->provider ?? '-' }}</p>
                            </div>
                            
                            <!-- Harga Jual Highlight -->
                            <div class="bg-indigo-50 px-6 py-4 rounded-2xl border border-indigo-100 text-center sm:text-right">
                                <p class="text-[10px] font-bold text-indigo-400 uppercase tracking-widest mb-1">Harga Jual</p>
                                <p class="text-2xl font-black text-indigo-600">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        {{-- Info Grid --}}
                        <div class="grid grid-cols-2 lg:grid-cols-3 gap-6 mt-10">
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Kode Produk</p>
                                <p class="font-bold text-slate-700">{{ $product->code ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Harga Modal</p>
                                <p class="font-bold text-slate-700">Rp {{ $product->cost_price ? number_format($product->cost_price, 0, ',', '.') : '-' }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Total Stok</p>
                                <p class="font-bold text-indigo-600 text-xl">{{ $product->current_stock ?? '0' }} <span class="text-xs text-slate-400 font-normal">Pcs</span></p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Expired Terdekat</p>
                                <p class="font-bold text-rose-500">
                                    {{ $product->nearest_expired_date ? \Carbon\Carbon::parse($product->nearest_expired_date)->translatedFormat('d F Y') : 'Tidak Ada' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bagian Bawah: Detail Batch Stok -->
            <div class="p-8 md:p-12 bg-slate-50/50">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-xl font-extrabold text-slate-800">Detail Batch Stok</h2>
                    <span class="text-xs text-slate-400 font-bold uppercase tracking-widest">History Stok Masuk</span>
                </div>

                {{-- Desktop Table --}}
                <div class="hidden md:block overflow-hidden rounded-3xl border border-slate-100 bg-white">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100">
                                <th class="px-8 py-5 text-center">Batch Ke-</th>
                                <th class="px-8 py-5">Qty Awal</th>
                                <th class="px-8 py-5">Sisa Stok</th>
                                <th class="px-8 py-5">Tanggal Kadaluarsa</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse ($product->stockIns as $index => $stock)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="px-8 py-5 text-center text-slate-400 font-bold">#{{ $loop->iteration }}</td>
                                    <td class="px-8 py-5 font-bold text-slate-700">{{ $stock->qty }} <span class="text-[10px] text-slate-400 font-normal">Pcs</span></td>
                                    <td class="px-8 py-5">
                                        @if($stock->remaining_qty == 0)
                                            <span class="px-3 py-1 rounded-lg bg-rose-50 text-rose-600 text-xs font-black uppercase">Habis</span>
                                        @else
                                            <span class="px-3 py-1 rounded-lg bg-emerald-50 text-emerald-600 text-xs font-black uppercase">{{ $stock->remaining_qty }} Tersedia</span>
                                        @endif
                                    </td>
                                    <td class="px-8 py-5 font-semibold text-slate-600">
                                        {{ $stock->expired_date ? \Carbon\Carbon::parse($stock->expired_date)->translatedFormat('d M Y') : '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-8 py-12 text-center text-slate-400 italic font-medium">Belum ada data batch stok masuk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Mobile Cards --}}
                <div class="md:hidden space-y-4">
                    @forelse ($product->stockIns as $stock)
                        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm relative overflow-hidden">
                            @if($stock->remaining_qty == 0)
                                <div class="absolute top-0 right-0 bg-rose-500 text-white text-[8px] font-bold px-3 py-1 rounded-bl-xl uppercase tracking-tighter">Habis</div>
                            @endif
                            <div class="flex justify-between items-center mb-4 border-b border-slate-50 pb-3">
                                <span class="text-xs font-bold text-slate-400 uppercase">Qty Awal: <b>{{ $stock->qty }}</b></span>
                                <span class="text-xs font-bold text-indigo-600 uppercase">Sisa: <b>{{ $stock->remaining_qty }}</b></span>
                            </div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Expired Date</p>
                            <p class="font-bold text-slate-700">{{ $stock->expired_date ? \Carbon\Carbon::parse($stock->expired_date)->translatedFormat('d M Y') : '-' }}</p>
                        </div>
                    @empty
                        <div class="text-center py-10 bg-white rounded-3xl border border-dashed border-slate-200">
                            <p class="text-slate-400 text-sm">Tidak ada data stok.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>