<x-app-layout>
    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-3xl mx-auto flex flex-col min-h-[85vh]">
        
        <!-- Kembali Section -->
        <div class="mb-6">
            <a href="/products" class="inline-flex items-center text-sm font-semibold text-slate-500 hover:text-indigo-600 transition group">
                <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Daftar Produk
            </a>
        </div>

        <div class="bg-white shadow-sm border border-slate-100 rounded-[2.5rem] overflow-hidden">
            <!-- Header Form -->
            <div class="p-8 md:p-10 border-b border-slate-50 bg-slate-50/30">
                <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">Edit Produk</h1>
                <p class="text-slate-500 text-sm mt-1">
                    Sesuaikan tipe dan kategori produk untuk akurasi laporan stok & margin.
                </p>
            </div>

            <form id="productForm" action="/products/{{ $product->id }}" method="POST" enctype="multipart/form-data" class="p-8 md:p-10 space-y-8">
                @csrf
                @method('PUT')

                <!-- Section: Informasi Utama -->
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Nama Produk</label>
                            <input type="text" name="name" value="{{ old('name', $product->name) }}" 
                                class="w-full px-5 py-4 bg-slate-50 border-slate-100 rounded-2xl focus:ring-indigo-500/20 focus:border-indigo-500 transition shadow-sm" placeholder="Contoh: Pulsa Telkomsel 10K">
                            @error('name') <p class="text-rose-500 text-xs mt-2 font-semibold">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Kode Produk / SKU</label>
                            <input type="text" name="code" value="{{ old('code', $product->code) }}" 
                                class="w-full px-5 py-4 bg-slate-50 border-slate-100 rounded-2xl focus:ring-indigo-500/20 focus:border-indigo-500 transition shadow-sm" placeholder="Otomatis jika kosong">
                            @error('code') <p class="text-rose-500 text-xs mt-2 font-semibold">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Provider</label>
                            <input type="text" name="provider" value="{{ old('provider', $product->provider) }}" 
                                class="w-full px-5 py-4 bg-slate-50 border-slate-100 rounded-2xl focus:ring-indigo-500/20 focus:border-indigo-500 transition shadow-sm" placeholder="Telkomsel, PLN, BRI, dsb">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Tipe Produk</label>
                            <select name="type" id="type" class="w-full px-5 py-4 bg-slate-50 border-slate-100 rounded-2xl focus:ring-indigo-500/20 focus:border-indigo-500 transition shadow-sm appearance-none">
                                @foreach ($typeLabels as $value => $label)
                                    <option value="{{ $value }}" {{ old('type', $product->type) == $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Kategori</label>
                            <select name="category" id="category" class="w-full px-5 py-4 bg-slate-50 border-slate-100 rounded-2xl focus:ring-indigo-500/20 focus:border-indigo-500 transition shadow-sm appearance-none"></select>
                            <p id="categoryHelp" class="text-[10px] text-slate-400 mt-2 font-medium px-1"></p>
                        </div>
                    </div>

                    {{-- <div class="grid grid-cols-1 md:grid-cols-2 gap-6"> --}}
                        <label class="block text-sm text-gray-600 mb-1 mt-3">Mode Nominal</label>
                        <select name="is_flexible_amount" class="w-full border p-2 mb-2">
                            <option value="0" {{ old('is_flexible_amount', (string) (int) $product->is_flexible_amount) == '0' ? 'selected' : '' }}>Fixed</option>
                            <option value="1" {{ old('is_flexible_amount', (string) (int) $product->is_flexible_amount) == '1' ? 'selected' : '' }}>Flexible</option>
                        </select>
                        <p class="text-xs text-gray-500 mb-2">
                            Pilih Flexible untuk layanan dengan nominal transaksi yang diinput saat POS.
                        </p>
                        @error('is_flexible_amount')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    {{-- </div> --}}
                </div>

                <hr class="border-slate-50">

                <!-- Section: Harga & Keuntungan -->
                <div class="bg-indigo-50/50 p-8 rounded-[2rem] border border-indigo-100/50">
                    <h2 class="text-sm font-black text-indigo-400 uppercase tracking-[0.2em] mb-6">Pengaturan Harga & Margin</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label id="costPriceLabel" class="block text-sm font-bold  mb-2 text-indigo-900">Harga Modal</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-5 flex items-center text-slate-400 font-bold">Rp</span>
                                <input id="cost_price" type="number" name="cost_price" value="{{ old('cost_price', $product->cost_price) }}" 
                                    class="w-full pl-12 pr-5 py-4 bg-white border-white rounded-2xl focus:ring-indigo-500/20 focus:border-indigo-500 transition shadow-sm">
                            </div>
                            <p id="costPriceHelp" class="text-[10px] text-indigo-400 mt-2 font-medium px-1"></p>
                        </div>

                        <div>
                            <label class="block text-sm font-bold  mb-2 text-indigo-900">Harga Jual</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-5 flex items-center text-slate-400 font-bold">Rp</span>
                                <input id="price" type="number" name="price" value="{{ old('price', $product->price) }}" 
                                    class="w-full pl-12 pr-5 py-4 bg-white border-white rounded-2xl focus:ring-indigo-500/20 focus:border-indigo-500 transition shadow-sm">
                            </div>
                        </div>
                    </div>

                    <!-- Margin Preview Card -->
                    <div id="marginCard" class="mt-6 p-4 rounded-2xl bg-white border border-indigo-100 flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest px-2">Estimasi Keuntungan</span>
                        <span id="marginText" class="text-lg font-black tracking-tight"></span>
                    </div>
                </div>

                <!-- Section: Media -->
                <div class="space-y-4">
                    <label class="block text-sm font-bold text-slate-700">Foto Produk</label>
                    <div class="flex items-center gap-6 p-6 bg-slate-50 rounded-[2rem] border border-dashed border-slate-200">
                        <div class="shrink-0">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="w-20 h-20 object-cover rounded-2xl border-2 border-white shadow-md">
                            @else
                                <div class="w-20 h-20 bg-white rounded-2xl border border-slate-100 flex items-center justify-center text-slate-300">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <input type="file" name="image" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 cursor-pointer">
                            <p class="text-[10px] text-slate-400 mt-2 italic">*Kosongkan jika tidak ingin merubah foto.</p>
                        </div>
                    </div>
                </div>

                <div class="pt-6">
                    <button type="submit" class="w-full py-5 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-[2rem] shadow-xl shadow-indigo-100 transition transform hover:-translate-y-1 active:scale-95 uppercase tracking-widest text-sm">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script JS Tetap Menggunakan Logika Kamu -->
    <script>
    const categoryOptions = @json($categoryOptions);
    const selectedCategory = @json(old('category', $product->category));
    const typeSelect = document.getElementById('type');
    const categorySelect = document.getElementById('category');
    const categoryHelp = document.getElementById('categoryHelp');
    const costInput = document.getElementById('cost_price');
    const costPriceLabel = document.getElementById('costPriceLabel');
    const costPriceHelp = document.getElementById('costPriceHelp');
    const priceInput = document.getElementById('price');
    const marginText = document.getElementById('marginText');
    const marginCard = document.getElementById('marginCard');

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
            categoryHelp.textContent = 'Pilih kategori barang yang perlu dikelola stok fisiknya.';
            costPriceLabel.textContent = 'Harga Modal';
            costPriceHelp.textContent = 'Mempengaruhi perhitungan nilai aset stok barang.';
        } else {
            categoryHelp.textContent = 'Pilih layanan digital (Pulsa, Transfer, Tagihan).';
            costPriceLabel.textContent = 'Modal / Saldo Keluar';
            costPriceHelp.textContent = 'Bisa diisi dengan harga beli dari aplikasi supplier.';
        }
    }

    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID').format(number);
    }

    function calculateMargin() {
        const cost = parseFloat(costInput.value) || 0;
        const price = parseFloat(priceInput.value) || 0;
        const margin = price - cost;

        if (price === 0 && cost === 0) {
            marginText.innerHTML = 'Rp 0';
            return;
        }

        if (margin < 0) {
            marginText.innerHTML = `Rugi Rp ${formatRupiah(Math.abs(margin))}`;
            marginText.className = 'text-lg font-black tracking-tight text-rose-500';
            marginCard.className = 'mt-6 p-4 rounded-2xl bg-rose-50 border border-rose-100 flex items-center justify-between';
        } else {
            marginText.innerHTML = `+ Rp ${formatRupiah(margin)}`;
            marginText.className = 'text-lg font-black tracking-tight text-emerald-600';
            marginCard.className = 'mt-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center justify-between';
        }
    }

    typeSelect.addEventListener('change', () => { syncCategoryOptions(); calculateMargin(); });
    costInput.addEventListener('input', calculateMargin);
    priceInput.addEventListener('input', calculateMargin);

    syncCategoryOptions();
    calculateMargin();
    </script>
</x-app-layout>