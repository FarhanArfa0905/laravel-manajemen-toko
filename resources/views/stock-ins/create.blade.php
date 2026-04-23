<x-app-layout>
    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-3xl mx-auto flex flex-col min-h-[85vh]">
        
        <!-- Kembali Section -->
        <div class="mb-6">
            <a href="{{ route('stock-ins.index') }}" class="inline-flex items-center text-sm font-semibold text-slate-500 hover:text-indigo-600 transition group">
                <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Data Stok
            </a>
        </div>

        <div class="bg-white shadow-sm border border-slate-100 rounded-[2.5rem] overflow-hidden">
            <!-- Header Form -->
            <div class="p-8 md:p-10 border-b border-slate-50 bg-slate-50/30">
                <div class="flex items-center gap-4 mb-2">
                    <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-100">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                    <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">Tambah Stok Masuk</h1>
                </div>
                <p class="text-slate-500 text-sm">
                    Pencatatan barang masuk untuk menambah stok fisik produk Ayra Cell.
                </p>
            </div>

            {{-- Validasi Error --}}
            @if ($errors->any())
                <div class="mx-8 mt-8 p-4 bg-rose-50 border border-rose-100 text-rose-600 rounded-2xl flex items-center gap-3">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="text-xs font-bold uppercase tracking-tight">Mohon periksa kembali inputan Anda.</p>
                </div>
            @endif

            <form action="{{ route('stock-ins.store') }}" method="POST" class="p-8 md:p-10 space-y-6">
                @csrf
                
                <!-- Pilih Produk -->
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 px-1">Pilih Produk</label>
                    <div class="relative">
                        <select name="product_id" class="w-full px-5 py-4 bg-slate-50 border-slate-100 rounded-2xl focus:ring-indigo-500/20 focus:border-indigo-500 transition shadow-sm appearance-none font-semibold text-slate-700">
                            <option value="">-- Pilih Produk Ayra Cell --</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }} ({{ $product->category_label ?? $product->category }})
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                    @error('product_id') <p class="text-rose-500 text-[10px] font-bold mt-2 px-1 uppercase">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Qty -->
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 px-1">Jumlah (Qty)</label>
                        <input type="number" name="qty" value="{{ old('qty') }}" placeholder="0"
                            class="w-full px-5 py-4 bg-slate-50 border-slate-100 rounded-2xl focus:ring-indigo-500/20 focus:border-indigo-500 transition shadow-sm font-bold text-slate-700">
                        @error('qty') <p class="text-rose-500 text-[10px] font-bold mt-2 px-1 uppercase">{{ $message }}</p> @enderror
                    </div>

                    <!-- Expired Date -->
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 px-1">Tanggal Kadaluarsa</label>
                        <input type="date" name="expired_date" value="{{ old('expired_date') }}"
                            class="w-full px-5 py-4 bg-slate-50 border-slate-100 rounded-2xl focus:ring-indigo-500/20 focus:border-indigo-500 transition shadow-sm font-semibold text-slate-600">
                        <p class="text-[10px] text-slate-400 mt-2 italic px-1">Opsional untuk produk fisik.</p>
                        @error('expired_date') <p class="text-rose-500 text-[10px] font-bold mt-2 px-1 uppercase">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Note -->
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 px-1">Catatan Tambahan</label>
                    <textarea name="note" rows="3" placeholder="Contoh: Nama supplier, kondisi barang, dsb."
                        class="w-full px-5 py-4 bg-slate-50 border-slate-100 rounded-2xl focus:ring-indigo-500/20 focus:border-indigo-500 transition shadow-sm font-medium text-slate-600">{{ old('note') }}</textarea>
                    @error('note') <p class="text-rose-500 text-[10px] font-bold mt-2 px-1 uppercase">{{ $message }}</p> @enderror
                </div>

                <div class="pt-6">
                    <button type="submit" class="w-full py-5 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-[2rem] shadow-xl shadow-indigo-100 transition transform hover:-translate-y-1 active:scale-95 uppercase tracking-[0.2em] text-xs">
                        Simpan Stok Masuk
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>