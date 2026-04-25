<x-app-layout>
    <div class="py-6 px-4 sm:px-6 lg:px-8 max-w-[1600px] mx-auto flex flex-col min-h-[90vh]">
        
        {{-- Navigation --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-4">
                <a href="/dashboard" class="p-3 bg-white rounded-2xl shadow-sm border border-slate-100 text-slate-400 hover:text-indigo-600 transition group">
                    <svg class="w-6 h-6 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <div>
                    <h1 class="text-2xl font-black text-slate-800 tracking-tight uppercase italic">Kasir POS</h1>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Ayra Cell Digital Solution</p>
                </div>
            </div>
            <div class="bg-white px-6 py-3 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
                <div class="text-right">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Kasir Aktif</p>
                    <p class="text-sm font-bold text-slate-700">{{ Auth::user()->name }}</p>
                </div>
                <div class="h-8 w-[1px] bg-slate-100"></div>
                <div class="text-right font-mono font-bold text-indigo-600">
                    {{ date('d/m/Y') }}
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            {{-- Kolom Kiri --}}
            <div class="lg:col-span-7 xl:col-span-8 space-y-6">
                {{-- Card Filter --}}
                <div class="bg-white p-6 rounded-[2.5rem] shadow-sm border border-slate-100">
                    <form method="GET" action="/pos" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
                        <div class="space-y-1">
                            <label class="text-[9px] font-black text-slate-400 uppercase ml-2">Tipe</label>
                            <select name="type" id="type" class="w-full bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-600 focus:ring-indigo-500/20 py-3 cursor-pointer appearance-none">
                                <option value="">Semua Tipe</option>
                                @foreach ($typeLabels as $value => $label)
                                    <option value="{{ $value }}" {{ $selectedType == $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-1">
                            <label class="text-[9px] font-black text-slate-400 uppercase ml-2">Kategori</label>
                            <select name="category" id="category" class="w-full bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-600 focus:ring-indigo-500/20 py-3 cursor-pointer appearance-none">
                                <option value="">Semua Kategori</option>
                            </select>
                        </div>

                        <div class="space-y-1">
                            <label class="text-[9px] font-black text-slate-400 uppercase ml-2">Pencarian</label>
                            <div class="relative">
                                <input type="text" name="search" value="{{ $search }}" placeholder="Nama produk..." 
                                    class="w-full pl-10 pr-4 py-3 bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-600 focus:ring-indigo-500/20">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </span>
                            </div>
                        </div>

                        <div class="flex items-end gap-2">
                            <button class="flex-1 py-3 bg-indigo-600 text-white text-[10px] font-black uppercase tracking-widest rounded-2xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">Cari</button>
                            <a href="/pos" class="p-3 bg-slate-100 text-slate-500 rounded-2xl hover:bg-slate-200 transition" title="Reset">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                            </a>
                        </div>
                    </form>
                </div>

                {{-- Grid Produk --}}
                <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
                    @forelse ($products as $product)
                        <div class="bg-white p-6 rounded-[2.5rem] border border-slate-100 hover:border-indigo-200 transition-all duration-300 shadow-sm flex flex-col justify-between">
                            <div class="flex justify-between items-start mb-4">
                                <div class="min-w-0 flex-1">
                                    <span class="px-2 py-1 rounded-lg text-[8px] font-black uppercase tracking-widest {{ $product->type === 'fisik' ? 'bg-amber-100 text-amber-600' : 'bg-sky-100 text-sky-600' }}">
                                        {{ $product->type_label }}
                                    </span>
                                    <h3 class="font-extrabold text-slate-800 text-lg mt-2 truncate">{{ $product->name }}</h3>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tight">{{ $product->category_label }} • {{ $product->provider ?? '-' }}</p>
                                </div>
                                <div class="text-right shrink-0">
                                    @if($product->is_flexible_amount)
                                        <div class="bg-rose-50 px-3 py-1 rounded-lg border border-rose-100">
                                            <span class="text-[9px] font-black text-rose-600 uppercase tracking-tighter italic italic">Input Nominal</span>
                                        </div>
                                    @else
                                        <p class="text-lg font-black text-indigo-600 italic leading-none">Rp {{ number_format($product->price) }}</p>
                                        <p class="text-[9px] font-bold text-slate-400 mt-1 uppercase">Stok: {{ $product->current_stock ?? '∞' }}</p>
                                    @endif
                                </div>
                            </div>

                            <form method="POST" action="/pos/add" class="mt-4 pt-4 border-t border-slate-50 flex items-center gap-3">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                
                                @if($product->is_flexible_amount)
                                    <div class="relative flex-1">
                                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 font-bold text-xs">Rp</span>
                                        <input type="number" name="amount" min="1" required placeholder="0"
                                            class="w-full pl-10 pr-4 py-3 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500/20">
                                    </div>
                                @else
                                    <div class="flex items-center bg-slate-50 rounded-2xl px-2">
                                        <input type="number" name="qty" value="1" min="1"
                                            class="w-16 bg-transparent border-none text-center font-bold text-slate-700 focus:ring-0">
                                        <span class="text-[10px] font-bold text-slate-300 pr-2 uppercase">Qty</span>
                                    </div>
                                @endif

                                <button class="bg-indigo-600 hover:bg-indigo-700 text-white p-3 rounded-2xl transition shadow-lg shadow-indigo-100">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                </button>
                            </form>
                        </div>
                    @empty
                        <div class="col-span-full py-20 text-center bg-white rounded-[3rem] border border-dashed border-slate-200">
                            <p class="text-slate-400 font-bold italic uppercase tracking-widest opacity-50">Produk tidak ditemukan</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Kolom Cart Kanan --}}
            <div class="lg:col-span-5 xl:col-span-4 sticky top-6">
                <div class="bg-white rounded-[3rem] shadow-2xl shadow-slate-200 border border-slate-100 overflow-hidden flex flex-col min-h-[700px] max-h-[85vh]">
                    <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
                        <div>
                            <h2 class="text-xl font-black text-slate-800 tracking-tight italic uppercase">Tagihan</h2>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Detail Pesanan Pelanggan</p>
                        </div>
                        <form method="POST" action="/pos/clear">
                            @csrf
                            <button class="p-3 bg-white text-rose-500 rounded-2xl shadow-sm border border-slate-100 hover:bg-rose-500 hover:text-white transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </div>

                    {{-- List Item --}}
                    <div class="flex-1 overflow-y-auto p-6 space-y-4">
                        @php $total = 0; @endphp
                        @forelse ($cart as $item)
                            @php
                                $subtotal = $item['price'] * $item['qty'];
                                $total += $subtotal;
                            @endphp
                            <div class="p-5 bg-slate-50 rounded-[2rem] border border-slate-100 group transition hover:border-indigo-100">
                                <div class="flex justify-between items-start gap-4">
                                    <div class="min-w-0 flex-1">
                                        <p class="font-black text-slate-800 text-sm truncate uppercase tracking-tight">{{ $item['name'] }}</p>
                                        
                                        @if(!empty($item['is_flexible_amount']))
                                            <div class="flex flex-wrap gap-2 mt-2">
                                                <span class="text-[9px] font-bold px-2 py-0.5 bg-white rounded-md text-slate-400 border border-slate-200">Pokok: Rp {{ number_format($item['amount']) }}</span>
                                                <span class="text-[9px] font-bold px-2 py-0.5 bg-indigo-50 rounded-md text-indigo-600 border border-indigo-100">Fee: Rp {{ number_format($item['fee']) }}</span>
                                            </div>
                                        @else
                                            <p class="text-[10px] text-slate-400 font-bold mt-1 tracking-widest uppercase italic">
                                                {{ $item['qty'] }} UNIT x Rp {{ number_format($item['price']) }}
                                            </p>
                                        @endif
                                    </div>
                                    <form method="POST" action="/pos/remove">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $item['product_id'] }}">
                                        <button class="text-slate-300 hover:text-rose-500 transition">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                                        </button>
                                    </form>
                                </div>
                                <div class="mt-4 pt-3 border-t border-slate-200/50 flex justify-between items-center">
                                    <span class="text-[9px] font-black text-slate-300 uppercase tracking-widest">Subtotal</span>
                                    <span class="text-sm font-black text-slate-800 italic tracking-tight">Rp {{ number_format($subtotal) }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="h-full flex flex-col items-center justify-center py-20 opacity-20">
                                <svg class="w-20 h-20 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                <p class="text-xs font-black uppercase tracking-widest">Belum ada transaksi</p>
                            </div>
                        @endforelse
                    </div>

                    {{-- Footer --}}
                    <div class="p-8 bg-slate-900">
                        <div class="flex justify-between items-center mb-8">
                            <div>
                                <span class="text-[10px] font-black text-indigo-400 uppercase tracking-[0.4em] italic leading-none">Grand Total</span>
                                <p class="text-[9px] text-slate-500 font-bold uppercase mt-1">Termasuk PPN & Admin</p>
                            </div>
                            <span class="text-3xl font-black text-white tracking-tighter italic">Rp {{ number_format($total) }}</span>
                        </div>
                        
                        <button type="button" onclick="openModal()" {{ empty($cart) ? 'disabled' : '' }}
                            class="w-full py-5 bg-indigo-600 text-white font-black rounded-[2rem] shadow-xl shadow-indigo-500/20 hover:bg-indigo-500 transition transform active:scale-95 uppercase tracking-[0.2em] text-xs disabled:opacity-50 disabled:cursor-not-allowed disabled:grayscale">
                            Konfirmasi Pembayaran
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal --}}
    <div id="checkoutModal" class="fixed inset-0 bg-slate-950/80 backdrop-blur-md hidden items-center justify-center z-[100] p-4 transition-all duration-300">
        <div class="bg-white rounded-[3.5rem] p-10 w-full max-w-md shadow-2xl transform scale-95 opacity-0 transition-all duration-300" id="modalContent">
            <div class="w-24 h-24 bg-emerald-50 text-emerald-500 rounded-[2.5rem] flex items-center justify-center mx-auto mb-8 shadow-inner">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h2 class="text-3xl font-black text-slate-800 text-center mb-2 tracking-tighter italic uppercase">Selesaikan?</h2>
            <p class="text-slate-400 text-center mb-10 font-medium px-4 text-sm leading-relaxed">Harap pastikan nominal uang yang diterima dari pelanggan sudah sesuai sebelum memproses transaksi ini.</p>
            
            <form id="checkoutForm" action="/pos/checkout" method="POST" class="grid grid-cols-2 gap-4">
                @csrf
                <button type="button" onclick="closeModal()" class="px-6 py-5 bg-slate-100 text-slate-500 font-black rounded-3xl hover:bg-slate-200 transition uppercase tracking-widest text-[10px]">Batal</button>
                <button type="submit" class="px-6 py-5 bg-indigo-600 text-white font-black rounded-3xl hover:bg-indigo-700 transition shadow-xl shadow-indigo-100 uppercase tracking-widest text-[10px]">Ya, Bayar!</button>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('checkoutModal');
        const modalContent = document.getElementById('modalContent');

        function openModal() {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 50);
        }

        function closeModal() {
            modalContent.classList.add('scale-95', 'opacity-0');
            modalContent.classList.remove('scale-100', 'opacity-100');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }

        // Logic Filter Kategori (Tetap berjalan dengan UI baru)
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
                if (selectedCategory === value) option.selected = true;
                categorySelect.appendChild(option);
            });
        }
        typeSelect.addEventListener('change', function() { renderCategories(this.value); });
        renderCategories(typeSelect.value);
    </script>
</x-app-layout>