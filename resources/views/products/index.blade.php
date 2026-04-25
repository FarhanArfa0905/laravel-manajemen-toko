<x-app-layout>
    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto flex flex-col min-h-[85vh]">
        {{-- Header & Action Section --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Daftar Produk</h1>
                <p class="text-slate-500 text-sm mt-1">Kelola stok produk fisik dan layanan digital Ayra Cell.</p>
            </div>
            {{-- Button Tambah Produk --}}
            <div class="flex items-center gap-3">
                <a href="/products/create"
                   class="inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-6 py-2.5 rounded-xl transition shadow-lg shadow-indigo-100 group">
                    <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Produk
                </a>
            </div>
        </div>
        {{-- Filter --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 mb-6">
            <form method="GET" action="/products" class="grid grid-cols-1 md:grid-cols-5 gap-3">
                <select name="type" id="type" class="w-full border border-slate-200 rounded-xl p-2.5 text-sm">
                    <option value="">Semua Tipe</option>
                    @foreach ($typeLabels as $value => $label)
                        <option value="{{ $value }}" {{ $selectedType == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                {{-- By Category --}}
                <select name="category" id="category" class="w-full border border-slate-200 rounded-xl p-2.5 text-sm">
                    <option value="">Semua Kategori</option>
                    @foreach ($filteredCategories as $value => $label)
                        <option value="{{ $value }}" {{ $selectedCategory == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                {{-- By Provider --}}
                <select name="provider" class="w-full border border-slate-200 rounded-xl p-2.5 text-sm">
                    <option value="">Semua Provider</option>
                    @foreach ($providers as $provider)
                        <option value="{{ $provider }}" {{ $selectedProvider == $provider ? 'selected' : '' }}>
                            {{ $provider }}
                        </option>
                    @endforeach
                </select>
                {{-- By Search --}}
                <input
                    type="text"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Cari nama produk..."
                    class="w-full border border-slate-200 rounded-xl p-2.5 text-sm"
                >
                <div class="flex gap-2">
                    <button class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-4 py-2.5 rounded-xl transition">
                        Filter
                    </button>
                    <a href="/products" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-4 py-2.5 rounded-xl text-center transition">
                        Reset
                    </a>
                </div>
            </form>
        </div>


        {{-- Mobile Card View  --}}
        <div class="md:hidden space-y-4">
            @forelse ($products as $product)
                <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 p-5 relative overflow-hidden">
                    <div class="absolute top-0 right-0">
                        <span class="text-[10px] font-bold px-4 py-1 rounded-bl-2xl uppercase tracking-wider
                            {{ $product->type === \App\Models\Product::TYPE_FISIK ? 'bg-amber-100 text-amber-700' : 'bg-sky-100 text-sky-700' }}">
                            {{ $product->type_label ?? ucfirst($product->type) }}
                        </span>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-20 h-20 rounded-2xl border border-slate-100 overflow-hidden bg-slate-50 flex items-center justify-center shrink-0">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            @else
                                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0 pr-10">
                            <h2 class="font-bold text-slate-800 text-lg truncate">{{ $product->name }}</h2>
                            <p class="text-xs text-slate-400 font-medium uppercase tracking-tight">{{ $product->category_label ?? $product->category }} • {{ $product->provider ?? '-' }}</p>
                            
                            <div class="mt-3">
                                <p class="text-indigo-600 font-extrabold text-lg">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-xs text-slate-500">Stok: <b>{{ $product->current_stock ?? '-' }}</b></span>
                                    <span class="text-slate-200">|</span>
                                    <span class="text-xs text-slate-500">Kode: {{ $product->code ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 pt-4 border-t border-slate-50 flex gap-2">
                        <a href="/products/{{ $product->id }}/edit" class="flex-1 bg-slate-100 hover:bg-amber-100 hover:text-amber-700 text-slate-600 font-bold py-2.5 rounded-xl text-xs text-center transition">Edit</a>
                        <a href="/products/{{ $product->id }}" class="flex-1 bg-slate-100 hover:bg-indigo-100 hover:text-indigo-700 text-slate-600 font-bold py-2.5 rounded-xl text-xs text-center transition">Detail</a>
                        <form id="delete-{{ $product->id }}" action="/products/{{ $product->id }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="confirmDelete({{ $product->id }})" class="p-2 text-slate-400 hover:text-rose-500 hover:bg-rose-50 rounded-lg transition" title="Hapus">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center py-20 bg-white rounded-[3rem] border border-dashed border-slate-200">
                    <p class="text-slate-400">Belum ada produk terdaftar</p>
                </div>
            @endforelse
        </div>

        {{-- Desktop Table View--}}
        <div class="hidden md:block bg-white shadow-sm border border-slate-100 rounded-[2.5rem] overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left border-separate border-spacing-0">
                    <thead>
                        <tr class="bg-slate-50/50 text-slate-500 uppercase text-[10px] tracking-widest font-bold border-b border-slate-100">
                            <th class="px-6 py-5">Produk</th>
                            <th class="px-6 py-5 text-center">Tipe & Kategori</th>
                            <th class="px-6 py-5">Harga (Modal/Jual)</th>
                            <th class="px-6 py-5 text-center">Stok</th>
                            <th class="px-6 py-5">Info Tambahan</th>
                            <th class="px-6 py-5 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse ($products as $product)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-xl border border-slate-100 overflow-hidden bg-slate-50 shrink-0">
                                            @if($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-[10px] text-slate-300">N/A</div>
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-bold text-slate-800 truncate">{{ $product->name }}</p>
                                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tight">{{ $product->code ?? 'Tanpa Kode' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-block px-3 py-1 rounded-lg text-[10px] font-bold uppercase mb-1
                                        {{ $product->type === \App\Models\Product::TYPE_FISIK ? 'bg-amber-100 text-amber-600' : 'bg-sky-100 text-sky-600' }}">
                                        {{ $product->type_label ?? ucfirst($product->type) }}
                                    </span>
                                    <p class="text-xs text-slate-500">{{ $product->category_label ?? $product->category }}</p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <p class="text-[10px] text-slate-400 font-bold mb-1">M: Rp {{ number_format($product->cost_price ?? 0, 0, ',', '.') }}</p>
                                    <p class="text-sm font-bold text-indigo-600 tracking-tight">J: Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-3 py-1 bg-slate-100 rounded-lg text-xs font-bold text-slate-700">
                                        {{ $product->current_stock ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-[10px]">
                                        <p class="text-slate-400 font-bold uppercase">Provider: <span class="text-slate-600">{{ $product->provider ?? '-' }}</span></p>
                                        <p class="text-slate-400 font-bold uppercase mt-1">Exp: <span class="text-slate-600">{{ $product->nearest_expired_date ? \Carbon\Carbon::parse($product->nearest_expired_date)->format('d/m/y') : '-' }}</span></p>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-1">
                                        <a href="/products/{{ $product->id }}/edit" class="p-2 text-slate-400 hover:text-amber-500 hover:bg-amber-50 rounded-lg transition" title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        <a href="/products/{{ $product->id }}" class="p-2 text-slate-400 hover:text-indigo-500 hover:bg-indigo-50 rounded-lg transition" title="Detail">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </a>
                                        <form id="delete-{{ $product->id }}" action="/products/{{ $product->id }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmDelete({{ $product->id }})" class="p-2 text-slate-400 hover:text-rose-500 hover:bg-rose-50 rounded-lg transition" title="Hapus">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-20 text-center text-slate-400 italic">
                                    Belum ada produk yang ditambahkan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-8">
            {{ $products->links() }}
        </div>
    </div>

    <!-- Script Konfirmasi Delete (Saran: Gunakan SweetAlert2 agar lebih mewah) -->
    <script>
        function confirmDelete(id) {
            if (confirm('Apakah Anda yakin ingin menghapus produk ini?')) {
                document.getElementById('delete-' + id).submit();
            }
        }

        // Search atau Filter
        const categoryOptions = @json($categoryOptions);
        const selectedCategory = @json($selectedCategory);

        const typeSelect = document.getElementById('type');
        const categorySelect = document.getElementById('category');

        function renderCategories(typeValue) {
            const categories = categoryOptions[typeValue] || {};

            categorySelect.innerHTML = '<option value="">Semua Kategori</option>';

            Object.entries(categories).forEach(([value, label]) => {
                const option = document.createElement('option');
                option.value = value;
                option.textContent = label;

                if (selectedCategory === value) {
                    option.selected = true;
                }

                categorySelect.appendChild(option);
            });
        }

        typeSelect.addEventListener('change', function () {
            renderCategories(this.value);
        });

        renderCategories(typeSelect.value);
    </script>
</x-app-layout>