<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockIn;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class POSController extends Controller
{
    //
    public function index()
    {
        // session()->forget('cart');
        $products = Product::all();
        $cart = session()->get('cart', []);
        // Nampilin Nama Item
        foreach ($cart as &$item) {
            $product = Product::find($item['product_id']);
            $item['name'] = $product->name;
        }
        return view('pos.index', compact('products', 'cart'));
    }

    public function add(Request $request)
    {
        
        $product = Product::find($request->product_id);
        $cart = session()->get('cart', []);
        $found = false;

        foreach ($cart as &$item) {
            if ($item['product_id'] == $product->id) {
                $item['qty'] += $request->qty;
                $found = true;
                break;
            }
        }

        if (!$found) {
            $cart[] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'qty' => $request->qty,
            ];
        }

        session()->put('cart', $cart);
        return back();
    }

    public function remove(Request $request)
    {
        $cart = session()->get('cart', []);
        $cart = array_filter($cart, function ($item) use ($request) {
            return $item['product_id'] != $request->product_id;
        });
        session()->put('cart', $cart);
        return back();
    }

    public function clear()
    {
        session()->forget('cart');
        return back();
    }

    public function checkout()
    {
        // dd('masuk SIni');
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return back()->with('error', 'Cart kosong');
        }
        DB::beginTransaction();

        try {
            // 1. Buat transaksi utama
            $transaction = Transaction::create([
                'total_price' => 0
            ]);
            $total = 0;
            // 2. Loop semua item di cart
            foreach ($cart as $item) {

                $qty = $item['qty'];
                $price = $item['price'];

                // ambil stock (FEFO)
                $stockIns = StockIn::with('product') // 🔥 FIX
                    ->where('product_id', $item['product_id'])
                    ->where('remaining_qty', '>', 0)
                    ->orderBy('expired_date', 'asc')
                    ->get();
                $cost = 0; // total modal
                foreach ($stockIns as $stock) {
                    if ($qty <= 0) break;
                    if ($stock->remaining_qty >= $qty) {
                        $cost += $qty * ($stock->product->cost_price ?? 0);
                        $stock->remaining_qty -= $qty;
                        $stock->save();
                        $qty = 0;
                    } else {
                        $cost += $stock->remaining_qty * $stock->product->cost_price;
                        $qty -= $stock->remaining_qty;
                        $stock->remaining_qty = 0;
                        $stock->save();
                    }
                }

                $subtotal = $item['price'] * $item['qty'];
                $profit = $subtotal - $cost;
                $total += $subtotal;

                // 3. Simpan detail transaksi
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item['product_id'],
                    'qty' => $item['qty'],
                    'selling_price' => $item['price'],
                    'cost_price' => $cost,
                    'profit' => $profit,
                ]);
            }

            // 4. Update total transaksi
            $transaction->update([
                'total_price' => $total
            ]);

            // 5. Clear cart
            session()->forget('cart');
            DB::commit();
            return redirect('/pos/invoice/'. $transaction->id)->with('success', 'Transaksi berhasil 🔥');

        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            // return back()->with('error', 'Terjadi error');
        }
    }

    public function invoice($id)
    {
        $transaction = Transaction::with('items.product')->findOrFail($id);
        return view('pos.invoice', compact('transaction'));
    }

    // History / Data penjualan
    public function history()
    {
        $transactions = Transaction::latest()->get();
        return view('pos.history', compact('transactions'));
    }

    // public function dashboard()
    // {
    //     // total penjualan hari ini
    //     $totalToday = Transaction::whereDate('created_at', today())
    //         ->sum('total_price');

    //     // jumlah transaksi hari ini
    //     $totalTransaction = Transaction::whereDate('created_at', today())
    //         ->count();

    //     // profit hari ini
    //     $profitToday = TransactionItem::whereDate('created_at', today())
    //         ->sum('profit');

        // // produk terlaris
        // $topProducts = TransactionItem::select('product_id')
        //     ->selectRaw('SUM(qty) as total')
        //     ->groupBy('product_id')
        //     ->orderByDesc('total')
        //     ->with('product')
        //     ->limit(5)
        //     ->get();

    //     return view('dashboard', compact(
    //         'totalToday',
    //         'totalTransaction',
    //         'profitToday',
    //         'topProducts'
    //     ));
    // }

    public function dashboard(Request $request)
    {
        //ambil filter (default: hari ini)
        $range = $request->range ?? 'today';

        $start = now();
        $end = now();

        if ($range === 'today') {
            $start = now()->startOfDay();
            $end = now()->endOfDay();
        } elseif ($range === 'week') {
            $start = now()->startOfWeek();
            $end = now()->endOfWeek();
        } elseif ($range === 'month') {
            $start = now()->startOfMonth();
            $end = now()->endOfMonth();
        } elseif ($range === 'custom') {
            $start = Carbon::parse($request->start);
            $end = Carbon::parse($request->end);
        }

        //data utama
        $totalRevenue = Transaction::whereBetween('created_at', [$start, $end])
            ->sum('total_price');
        $totalProfit = TransactionItem::whereBetween('created_at', [$start, $end])
            ->sum('profit');
        $totalTransaction = Transaction::whereBetween('created_at', [$start, $end])
            ->count();

        // produk terlaris
        $topProducts = TransactionItem::select('product_id')
            ->selectRaw('SUM(qty) as total')
            ->groupBy('product_id')
            ->orderByDesc('total')
            ->with('product')
            ->limit(5)
            ->get();

        //chart (per hari)
        $chartData = Transaction::selectRaw('DATE(created_at) as date, SUM(total_price) as total')
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $labels = $chartData->pluck('date');
        $values = $chartData->pluck('total');

        return view('dashboard', compact(
            'totalRevenue',
            'totalProfit',
            'totalTransaction',
            'topProducts',
            'labels',
            'values',
            'range'
        ));
    }

    public function historyItems(Request $request)
    {
        $query = TransactionItem::with(['product', 'transaction']);
        // 🔍 SEARCH (nama produk)
        if ($request->search) {
            $query->whereHas('product', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }
        // 📅 FILTER TANGGAL
        if ($request->date) {
            $query->whereDate('created_at', $request->date);
        }
        $items = $query->latest()->paginate(10);
        return view('pos.detail', compact('items'));
    }
}
