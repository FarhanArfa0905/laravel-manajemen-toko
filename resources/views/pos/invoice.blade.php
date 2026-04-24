<x-app-layout>
    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-2xl mx-auto flex flex-col min-h-[85vh]">
        
        <!-- Header & Navigasi (Sembunyi saat Print) -->
        <div class="flex items-center justify-between mb-8 print:hidden">
            <a href="/pos" class="inline-flex items-center text-sm font-bold text-slate-500 hover:text-indigo-600 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Kasir
            </a>
            
            <div class="flex gap-2">
                <a href="/transactions" class="px-4 py-2 bg-white border border-slate-200 text-slate-600 font-bold rounded-xl text-xs hover:bg-slate-50 transition">Riwayat</a>
                <button onclick="window.print()" class="inline-flex items-center px-6 py-2 bg-indigo-600 text-white font-bold rounded-xl text-xs shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Cetak Struk
                </button>
            </div>
        </div>

        <!-- AREA INVOICE / STRUK -->
        <div class="bg-white shadow-2xl shadow-slate-200/50 rounded-[2.5rem] border border-slate-100 overflow-hidden print:shadow-none print:border-none print:rounded-none">
            
            <!-- Branding Struk -->
            <div class="p-10 text-center border-b border-dashed border-slate-200">
                <div class="w-16 h-16 bg-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-xl shadow-indigo-100 print:shadow-none">
                    <span class="text-white font-black text-3xl">A</span>
                </div>
                <h1 class="text-2xl font-black text-slate-800 uppercase tracking-widest">Ayra Cell</h1>
                <p class="text-xs text-slate-400 font-bold mt-1 tracking-tighter uppercase">Solusi Digital & Top Up Terpercaya</p>
                <p class="text-[10px] text-slate-400 mt-1 uppercase tracking-widest italic">Jl. Raya Utama No. 123 • 0812-3456-789</p>
            </div>

            <!-- Meta Data -->
            <div class="px-10 py-6 bg-slate-50/50 flex flex-col sm:flex-row justify-between gap-4 text-[10px] font-black uppercase tracking-widest text-slate-400 border-b border-slate-50 print:bg-transparent">
                <div>ID Transaksi: <span class="text-slate-800 ml-1">#{{ $transaction->id }}</span></div>
                <div>Tanggal: <span class="text-slate-800 ml-1">{{ $transaction->created_at->format('d/m/Y H:i') }}</span></div>
            </div>

            <!-- List Item -->
            <div class="p-10">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">
                            <th class="pb-4">Deskripsi Produk</th>
                            <th class="pb-4 text-center">Qty</th>
                            <th class="pb-4 text-right">Harga</th>
                            <th class="pb-4 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($transaction->items as $item)
                            <tr class="text-slate-700">
                                <td class="py-5 font-bold text-sm">{{ $item->product->name }}</td>
                                <td class="py-5 text-center text-xs font-bold">{{ $item->qty }}</td>
                                <td class="py-5 text-right text-xs">Rp {{ number_format($item->selling_price) }}</td>
                                <td class="py-5 text-right text-sm font-black text-slate-900 italic">Rp {{ number_format($item->selling_price * $item->qty) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Summary -->
                <div class="mt-10 pt-8 border-t-2 border-slate-800 border-dotted flex justify-between items-center">
                    <div class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-400">Total Pembayaran</div>
                    <div class="text-3xl font-black text-indigo-600 tracking-tighter">
                        Rp {{ number_format($transaction->total_price) }}
                    </div>
                </div>

                <!-- Footer Struk -->
                <div class="mt-16 text-center">
                    <p class="text-xs font-bold text-slate-800 italic uppercase tracking-widest mb-1 italic">Terima Kasih</p>
                    <p class="text-[10px] text-slate-400 font-medium">Struk ini adalah bukti pembayaran yang sah.<br>Ayra Cell - Cepat, Murah, & Aman.</p>
                </div>
            </div>

            <!-- Gunting Line (Visual Only) -->
            <div class="h-4 bg-slate-50 border-t border-slate-100 flex items-center justify-center print:hidden">
                <div class="w-full border-t border-dashed border-slate-300"></div>
            </div>
        </div>
    </div>

    <!-- Script CSS Khusus Print -->
    <style>
        @media print {
            body { 
                background-color: white !important; 
                -webkit-print-color-adjust: exact; 
            }
            /* Hilangkan elemen navigasi dashboard jika ada */
            nav, aside, footer { display: none !important; }
            .max-w-2xl { max-width: 100% !important; margin: 0 !important; }
            .py-8 { padding: 0 !important; }
        }
    </style>
</x-app-layout>