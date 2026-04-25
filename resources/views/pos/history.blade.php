<x-app-layout>
    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto flex flex-col min-h-[85vh]">
        
        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-100">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    </div>
                    <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Riwayat Transaksi</h1>
                </div>
                <p class="text-slate-500 text-sm mt-1">Daftar seluruh aktivitas penjualan di Ayra Cell.</p>
            </div>

            {{--  --}}
            <div class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-widest bg-white px-4 py-2 rounded-xl border border-slate-100 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002-2z"></path></svg>
                <span>{{ date('F Y') }}</span>
            </div>
        </div>

        {{-- Mobile View  --}}
        <div class="md:hidden space-y-4">
            @forelse($transactions as $trx)
                <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 p-6 relative overflow-hidden group active:scale-[0.98] transition-transform">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <span class="text-[10px] font-black text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full uppercase tracking-widest">
                                #{{ $trx->id }}
                            </span>
                            <p class="text-xs text-slate-400 font-medium mt-2 italic">
                                {{ $trx->created_at->translatedFormat('d M Y, H:i') }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Total</p>
                            <p class="text-lg font-black text-slate-800">Rp {{ number_format($trx->total_price) }}</p>
                        </div>
                    </div>
                    
                    <a href="/pos/invoice/{{ $trx->id }}" class="w-full inline-flex items-center justify-center bg-slate-50 hover:bg-indigo-600 hover:text-white text-slate-600 font-bold py-3 rounded-2xl text-xs transition duration-300">
                        Lihat Detail Struk
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>
            @empty
                <div class="text-center py-20 bg-white rounded-[2.5rem] border border-dashed border-slate-200">
                    <p class="text-slate-400 text-sm font-medium italic">Belum ada transaksi hari ini.</p>
                </div>
            @endforelse
        </div>

        {{-- Desktop View --}}
        <div class="hidden md:block bg-white shadow-sm border border-slate-100 rounded-[2.5rem] overflow-hidden">
            <table class="w-full text-left border-separate border-spacing-0">
                <thead>
                    <tr class="bg-slate-50/50 text-slate-500 uppercase text-[10px] tracking-[0.2em] font-black">
                        <th class="px-8 py-6 border-b border-slate-50">ID Transaksi</th>
                        <th class="px-8 py-6 border-b border-slate-100">Waktu Penjualan</th>
                        <th class="px-8 py-6 border-b border-slate-100 text-right">Total Nominal</th>
                        <th class="px-8 py-6 border-b border-slate-100 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($transactions as $trx)
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            <td class="px-8 py-5">
                                <span class="font-bold text-slate-400 group-hover:text-indigo-600 transition-colors">#{{ $trx->id }}</span>
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-slate-700">{{ $trx->created_at->translatedFormat('d F Y') }}</span>
                                    <span class="text-[10px] text-slate-400 font-medium uppercase tracking-tight">{{ $trx->created_at->format('H:i') }} WIB</span>
                                </div>
                            </td>
                            <td class="px-8 py-5 text-right whitespace-nowrap">
                                <span class="text-base font-black text-slate-800 tracking-tight">
                                    Rp {{ number_format($trx->total_price) }}
                                </span>
                            </td>
                            <td class="px-8 py-5 text-center whitespace-nowrap">
                                <a href="/pos/invoice/{{ $trx->id }}" 
                                   class="inline-flex items-center px-5 py-2 bg-slate-100 hover:bg-indigo-600 text-slate-600 hover:text-white text-[11px] font-black uppercase tracking-widest rounded-xl transition-all duration-300">
                                    Detail
                                    <svg class="w-3.5 h-3.5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-8 py-20 text-center text-slate-400 italic font-medium">
                                Belum ada riwayat transaksi yang tercatat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if(method_exists($transactions, 'links'))
            <div class="mt-8">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>
</x-app-layout>