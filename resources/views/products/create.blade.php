<x-app-layout>
    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-3xl mx-auto flex flex-col min-h-[85vh]">
        
        {{-- Back Button --}}
        <div class="mb-6">
            <a href="/products" class="inline-flex items-center text-sm font-semibold text-slate-500 hover:text-indigo-600 transition group">
                <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Daftar Produk
            </a>
        </div>

        <div class="bg-white shadow-sm border border-slate-100 rounded-[2.5rem] overflow-hidden">
            {{-- Header --}}
            <div class="p-8 md:p-10 border-b border-slate-50 bg-slate-50/30">
                <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">Tambah Produk Baru</h1>
                <p class="text-slate-500 text-sm mt-1">
                    Pisahkan produk fisik (stok) dan digital (pulsa/layanan) dengan benar.
                </p>
            </div>

            {{-- Validasi Error --}}
            @if ($errors->any())
                <div class="mx-8 mt-8 p-4 bg-rose-50 border border-rose-100 text-rose-600 rounded-2xl flex items-center gap-3">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="text-xs font-bold uppercase tracking-tight">Ada beberapa data yang perlu diperbaiki.</p>
                </div>
            @endif

            <form action="/products" method="POST" enctype="multipart/form-data" id="productForm" class="p-8 md:p-10 space-y-8">
                @csrf

                {{-- Ident Produk --}}
                <div class="space-y-6">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 px-1">Nama Produk</label>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Voucher Telkomsel 10GB" 
                            class="w-full px-5 py-4 bg-slate-50 border-slate-100 rounded-2xl focus:ring-indigo-500/20 focus:border-indigo-500 transition shadow-sm font-semibold text-slate-700">
                        @error('name') <p class="text-rose-500 text-[10px] font-bold mt-2 px-1 uppercase">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 px-1">Kode Produk / SKU</label>
                            <input type="text" name="code" value="{{ old('code') }}" placeholder="Kosongkan jika ingin otomatis" 
                                class="w-full px-5 py-4 bg-slate-50 border-slate-100 rounded-2xl focus:ring-indigo-500/20 focus:border-indigo-500 transition shadow-sm font-semibold text-slate-700">
                            @error('code') <p class="text-rose-500 text-[10px] font-bold mt-2 px-1 uppercase">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 px-1">Provider</label>
                            <input type="text" name="provider" value="{{ old('provider') }}" placeholder="Dana, BRI, Telkomsel" 
                                class="w-full px-5 py-4 bg-slate-50 border-slate-100 rounded-2xl focus:ring-indigo-500/20 focus:border-indigo-500 transition shadow-sm font-semibold text-slate-700">
                        </div>
                    </div>
                </div>

                {{-- Section Type & kategori --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 px-1">Tipe Produk</label>
                        <select name="type" id="type" class="w-full px-5 py-4 bg-slate-50 border-slate-100 rounded-2xl focus:ring-indigo-500/20 focus:border-indigo-500 transition shadow-sm appearance-none font-bold text-indigo-600">
                            @foreach ($typeLabels as $value => $label)
                                <option value="{{ $value }}" {{ old('type', \App\Models\Product::TYPE_FISIK) == $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 px-1">Kategori</label>
                        <select name="category" id="category" class="w-full px-5 py-4 bg-slate-50 border-slate-100 rounded-2xl focus:ring-indigo-500/20 focus:border-indigo-500 transition shadow-sm appearance-none font-semibold text-slate-700"></select>
                        <p id="categoryHelp" class="text-[10px] text-slate-400 mt-2 font-medium px-1"></p>
                    </div>
                </div>

                <hr class="border-slate-50">

                {{-- Section Keuntungan --}}
                <div class="bg-indigo-50/50 p-8 rounded-[2.5rem] border border-indigo-100/50 space-y-6">
                    <div class="flex items-center justify-between mb-2">
                        <h2 class="text-sm font-black text-indigo-400 uppercase tracking-[0.2em]">Harga & Konfigurasi</h2>
                        <div class="flex items-center gap-2">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Mode Nominal:</span>
                            <select name="is_flexible_amount" class="text-[10px] font-bold bg-white border-none rounded-lg focus:ring-0 py-1 px-3 text-indigo-600 shadow-sm cursor-pointer">
                                <option value="0" {{ old('is_flexible_amount', '0') == '0' ? 'selected' : '' }}>FIXED (Tetap)</option>
                                <option value="1" {{ old('is_flexible_amount') == '1' ? 'selected' : '' }}>FLEXIBLE (Bebas)</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label id="costPriceLabel" class="block text-[10px] font-black text-indigo-900 uppercase tracking-[0.2em] mb-2 px-1">Harga Modal</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-5 flex items-center text-slate-400 font-bold text-xs">Rp</span>
                                <input id="cost_price" type="number" name="cost_price" value="{{ old('cost_price') }}" 
                                    class="w-full pl-12 pr-5 py-4 bg-white border-white rounded-2xl focus:ring-indigo-500/20 focus:border-indigo-500 transition shadow-sm font-bold text-slate-700">
                            </div>
                            <p id="costPriceHelp" class="text-[10px] text-indigo-400/70 mt-2 italic px-1"></p>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-indigo-900 uppercase tracking-[0.2em] mb-2 px-1">Harga Jual</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-5 flex items-center text-slate-400 font-bold text-xs">Rp</span>
                                <input type="number" name="price" value="{{ old('price') }}" 
                                    class="w-full pl-12 pr-5 py-4 bg-white border-white rounded-2xl focus:ring-indigo-500/20 focus:border-indigo-500 transition shadow-sm font-bold text-slate-700">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Media / Image --}}
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 px-1">Foto Produk (Opsional)</label>
                    <div class="flex items-center justify-center w-full">
                        <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-100 border-dashed rounded-[2rem] cursor-pointer bg-slate-50 hover:bg-slate-100 transition">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                <p class="text-xs text-slate-500">Klik untuk upload atau drag and drop</p>
                            </div>
                            <input type="file" name="image" class="hidden" />
                        </label>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full py-5 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-[2.5rem] shadow-xl shadow-indigo-100 transition transform hover:-translate-y-1 active:scale-95 uppercase tracking-[0.2em] text-xs">
                        Simpan Produk Baru
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script JS -->
    <script>
        const categoryOptions = @json($categoryOptions);
        const selectedCategory = @json(old('category'));
        const typeSelect = document.getElementById('type');
        const categorySelect = document.getElementById('category');
        const categoryHelp = document.getElementById('categoryHelp');
        const costPriceInput = document.getElementById('cost_price');
        const costPriceLabel = document.getElementById('costPriceLabel');
        const costPriceHelp = document.getElementById('costPriceHelp');

        function syncCategoryOptions() {
            const type = typeSelect.value;
            const categories = categoryOptions[type] || {};
            const currentValue = categorySelect.value || selectedCategory;

            categorySelect.innerHTML = '<option value="">Pilih kategori</option>';

            Object.entries(categories).forEach(([value, label]) => {
                const option = document.createElement('option');
                option.value = value;
                option.textContent = label;
                if (currentValue === value) option.selected = true;
                categorySelect.appendChild(option);
            });

            if (type === 'fisik') {
                categoryHelp.textContent = 'Gunakan untuk barang dengan stok nyata.';
                costPriceLabel.textContent = 'Harga Modal';
                costPriceHelp.textContent = 'Wajib untuk perhitungan untung-rugi stok barang.';
            } else {
                categoryHelp.textContent = 'Gunakan untuk layanan saldo atau jasa.';
                costPriceLabel.textContent = 'Modal / Saldo Keluar';
                costPriceHelp.textContent = 'Opsional, untuk melacak pengeluaran saldo supplier.';
            }
        }

        typeSelect.addEventListener('change', () => {
            categorySelect.value = '';
            syncCategoryOptions();
        });

        syncCategoryOptions();
    </script>
</x-app-layout>