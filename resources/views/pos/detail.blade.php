<x-app-layout>
    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto flex flex-col min-h-[85vh]">
        
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-100">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Detail Item Terjual</h1>
                </div>
                <p class="text-slate-500 text-sm mt-1">Laporan rincian produk dan profitabilitas per item.</p>
            </div>

            {{-- FILTER BOX --}}
            <form method="GET" class="flex flex-wrap items-center gap-3 bg-white p-2 rounded-[1.5rem] shadow-sm border border-slate-100">
                <input type="date" name="date" value="{{ request('date') }}"
                    class="border-none bg-slate-50 rounded-xl text-xs font-bold text-slate-600 focus:ring-indigo-500">
                
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..."
                        class="pl-9 border-none bg-slate-50 rounded-xl text-xs font-bold text-slate-600 focus:ring-indigo-500 w-44">
                </div>

                <button class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-black uppercase tracking-widest px-6 py-2.5 rounded-xl transition shadow-lg shadow-indigo-100">
                    Filter
                </button>
            </form>
        </div>

        {{-- MOBILE CARD VIEW --}}
        <div class="md:hidden space-y-4 mb-6">
            @foreach($items as $item)
                <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div class="min-w-0">
                            <h3 class="font-bold text-slate-800 text-base truncate">{{ $item->product->name }}</h3>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest italic">{{ $item->transaction->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <span class="text-xs font-black text-indigo-600 bg-indigo-50 px-2 py-1 rounded-lg">Qty: {{ $item->qty }}</span>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 border-t border-slate-50 pt-4">
                        <div>
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-1">Subtotal</p>
                            <p class="text-sm font-bold text-slate-700 text-sm italic">Rp {{ number_format($item->selling_price * $item->qty) }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-1 italic">Profit</p>
                            <p class="text-sm font-black text-emerald-600 italic">Rp {{ number_format($item->profit) }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- DESKTOP TABLE VIEW --}}
        <div class="hidden md:block bg-white shadow-sm border border-slate-100 rounded-[2.5rem] overflow-hidden">
            <table class="w-full text-left border-separate border-spacing-0">
                <thead>
                    <tr class="bg-slate-50/50 text-slate-500 uppercase text-[10px] tracking-[0.2em] font-black border-b border-slate-100">
                        <th class="px-8 py-5">Waktu Transaksi</th>
                        <th class="px-8 py-5">Produk</th>
                        <th class="px-8 py-5 text-center">Qty</th>
                        <th class="px-8 py-5 text-right">Harga Jual</th>
                        <th class="px-8 py-5 text-right font-black italic">Subtotal</th>
                        <th class="px-8 py-5 text-right">Keuntungan (Profit)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($items as $item)
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            <td class="px-8 py-4 whitespace-nowrap">
                                <div class="flex flex-col">
                                    <span class="text-xs font-bold text-slate-700">{{ $item->transaction->created_at->translatedFormat('d M Y') }}</span>
                                    <span class="text-[9px] text-slate-400 font-medium tracking-tighter">{{ $item->transaction->created_at->format('H:i') }} WIB</span>
                                </div>
                            </td>
                            <td class="px-8 py-4 font-bold text-slate-800">{{ $item->product->name }}</td>
                            <td class="px-8 py-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-bold bg-slate-100 text-slate-600">
                                    {{ $item->qty }}
                                </span>
                            </td>
                            <td class="px-8 py-4 text-right text-xs font-medium text-slate-500 italic whitespace-nowrap">
                                Rp {{ number_format($item->selling_price) }}
                            </td>
                            <td class="px-8 py-4 text-right whitespace-nowrap">
                                <span class="text-sm font-bold text-slate-800 italic">Rp {{ number_format($item->selling_price * $item->qty) }}</span>
                            </td>
                            <td class="px-8 py-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2">
                                    <span class="text-sm font-black text-emerald-600 italic">
                                        Rp {{ number_format($item->profit) }}
                                    </span>
                                    <div class="w-1 h-4 bg-emerald-100 rounded-full"></div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="mt-8">
            {{ $items->links() }}
        </div>
    </div>
</x-app-layout>