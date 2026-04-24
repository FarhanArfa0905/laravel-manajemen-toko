<x-app-layout>
    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-3xl mx-auto flex flex-col min-h-[85vh]">
        
        <!-- Back Navigation -->
        <div class="mb-6">
            <a href="/stock-outs" class="inline-flex items-center text-sm font-semibold text-slate-500 hover:text-rose-600 transition group">
                <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Riwayat Keluar
            </a>
        </div>

        <div class="bg-white shadow-sm border border-slate-100 rounded-[2.5rem] overflow-hidden">
            <!-- Header Form -->
            <div class="p-8 md:p-10 border-b border-slate-50 bg-rose-50/30">
                <div class="flex items-center gap-4 mb-2">
                    <div class="w-12 h-12 bg-rose-500 rounded-2xl flex items-center justify-center shadow-xl shadow-rose-200">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">Catat Stok Keluar</h1>
                        <p class="text-slate-500 text-sm mt-1 font-medium italic">Penyesuaian stok non-penjualan.</p>
                    </div>
                </div>
            </div>

            {{-- Alert Section --}}
            <div class="px-8 md:px-10 mt-8 space-y-4">
                @if ($errors->any())
                    <div class="p-4 bg-rose-50 border border-rose-100 text-rose-600 rounded-2xl flex items-center gap-3">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <p class="text-[10px] font-black uppercase tracking-widest leading-none">Data input tidak valid</p>
                    </div>
                @endif

                @if(session('error'))
                    <div class="p-4 bg-amber-50 border border-amber-100 text-amber-700 rounded-2xl flex items-center gap-3 font-bold text-xs italic">
                        ⚠️ {{ session('error') }}
                    </div>
                @endif
            </div>

            <form action="/stock-outs" method="POST" class="p-8 md:p-10 space-y-8">
                @csrf

                <!-- Pilih Produk -->
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 px-1">Pilih Produk Fisik</label>
                    <div class="relative group">
                        <select name="product_id" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-rose-500/20 transition shadow-sm appearance-none font-bold text-slate-700 cursor-pointer">
                            <option value="">-- Cari Nama Produk --</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }} (Tersedia: {{ $product->current_stock ?? 0 }} Pcs)
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4 4 4-4"></path></svg>
                        </div>
                    </div>
                    @error('product_id') <p class="text-rose-500 text-[10px] font-bold mt-2 px-1 uppercase">{{ $message }}</p> @enderror
                </div>

                <!-- Qty Keluar -->
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 px-1">Jumlah Pengurangan (Qty)</label>
                    <div class="relative">
                        <input type="number" name="qty" value="{{ old('qty') }}" min="1" placeholder="0"
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-rose-500/20 transition shadow-sm font-black text-slate-800 text-lg">
                        <span class="absolute inset-y-0 right-6 flex items-center text-slate-300 font-bold text-xs uppercase tracking-widest pointer-events-none">Pcs</span>
                    </div>
                    <p class="text-[10px] text-slate-400 mt-3 italic px-1">Pastikan jumlah yang dikurangi tidak melebihi stok yang tersedia.</p>
                    @error('qty') <p class="text-rose-500 text-[10px] font-bold mt-2 px-1 uppercase">{{ $message }}</p> @enderror
                </div>

                <!-- Note / Alasan -->
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 px-1">Alasan Pengeluaran Stok</label>
                    <textarea name="note" rows="4" placeholder="Jelaskan alasan (Contoh: Layar pecah saat pengiriman, Kadaluarsa, Unit sampel pameran, dll)"
                        class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-rose-500/20 transition shadow-sm font-medium text-slate-600 leading-relaxed">{{ old('note') }}</textarea>
                    @error('note') <p class="text-rose-500 text-[10px] font-bold mt-2 px-1 uppercase">{{ $message }}</p> @enderror
                </div>

                <div class="pt-4 pb-2">
                    <button type="submit" class="w-full py-5 bg-rose-500 hover:bg-rose-600 text-white font-black rounded-[2rem] shadow-xl shadow-rose-100 transition transform hover:-translate-y-1 active:scale-95 uppercase tracking-[0.2em] text-xs">
                        Konfirmasi & Kurangi Stok
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>