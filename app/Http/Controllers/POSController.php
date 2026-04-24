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
    public function index(Request $request)
    {
        // session()->forget('cart');
        $query = Product::with(['stockIns', 'stockOuts']);

        // Logika Filter
        if($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if($request->filled('provider')) {
            $query->where('provider', $request->provider);
        }
        if($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search .'%');
        }

        // Filter by Categories
        $filteredCategories = [];
        if ($request->filled('type')) {
            $filteredCategories = Product::CATEGORY_OPTIONS[$request->type] ?? [];
        }

        $products = $query->orderBy('name')->get();
        $cart = session()->get('cart', []);

        // Nampilin Nama Item
        foreach ($cart as &$item) {
            $product = Product::find($item['product_id']);
            $item['name'] = $product->name;
        }

        $providerQuery = Product::query();

        if ($request->filled('type')) {
            $providerQuery->where('type', $request->type);
        }

        if ($request->filled('category')) {
            $providerQuery->where('category', $request->category);
        }

        $providers = $providerQuery
            ->whereNotNull('provider')
            ->where('provider', '!=', '')
            ->select('provider')
            ->distinct()
            ->orderBy('provider')
            ->pluck('provider');

        return view('pos.index', [
            'products' => $products,
            'cart' => $cart,
            'providers' => $providers,
            'filteredCategories' => $filteredCategories,
            'selectedType' => $request->type,
            'selectedCategory' => $request->category,
            'selectedProvider' => $request->provider,
            'search' => $request->search,
            'typeLabels' => Product::TYPE_LABELS,
            'categoryOptions' => Product::CATEGORY_OPTIONS,
        ]);
    }

    public function add(Request $request)
    {
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'qty' => 'nullable|integer|min:1',
        'amount' => 'nullable|integer|min:1',
    ]);

    $product = Product::with(['stockIns', 'stockOuts'])->findOrFail($request->product_id);
    $cart = session()->get('cart', []);

    if ($product->is_flexible_amount) {
        $request->validate([
            'amount' => 'required|integer|min:1',
        ]);

        $amount = (int) $request->amount;
        $fee = $this->calculateFlexibleFee($amount);
        $sellingPrice = $amount + $fee;

        $cart[] = [
            'product_id' => $product->id,
            'name' => $product->name,
            'price' => $sellingPrice,
            'qty' => 1,
            'amount' => $amount,
            'fee' => $fee,
            'is_flexible_amount' => true,
        ];

        session()->put('cart', $cart);

        return back();
    }

    $request->validate([
        'qty' => 'required|integer|min:1',
    ]);

    $currentCartQty = 0;

    foreach ($cart as $item) {
        if ($item['product_id'] == $product->id) {
            $currentCartQty = $item['qty'];
            break;
        }
    }

    if ($product->type === Product::TYPE_FISIK) {
        $requestedQty = $request->qty;
        $availableStock = $product->current_stock ?? 0;
        $totalQtyAfterAdd = $currentCartQty + $requestedQty;

        if ($totalQtyAfterAdd > $availableStock) {
            return back()->with('error', 'Stok fisik tidak cukup untuk ditambahkan ke cart.');
        }
    }

    $found = false;

    foreach ($cart as &$item) {
        if ($item['product_id'] == $product->id) {
            $item['qty'] += $request->qty;
            $found = true;
            break;
        }
    }

    if (! $found) {
        $cart[] = [
            'product_id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'qty' => $request->qty,
            'is_flexible_amount' => false,
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
            // foreach ($cart as $item) {
            //     $product = Product::with(['stockIns', 'stockOuts'])->findOrFail($item['product_id']);
            //     $cost = 0;
            //     $qty = $item['qty'];
            //     $price = $item['price'];

            //     // ambil stock (FEFO)
            //     $stockIns = StockIn::with('product') // 🔥 FIX
            //         ->where('product_id', $item['product_id'])
            //         ->where('remaining_qty', '>', 0)
            //         ->orderBy('expired_date', 'asc')
            //         ->get();
            //     $cost = 0; // total modal
            //     foreach ($stockIns as $stock) {
            //         if ($qty <= 0) break;
            //         if ($stock->remaining_qty >= $qty) {
            //             $cost += $qty * ($stock->product->cost_price ?? 0);
            //             $stock->remaining_qty -= $qty;
            //             $stock->save();
            //             $qty = 0;
            //         } else {
            //             $cost += $stock->remaining_qty * $stock->product->cost_price;
            //             $qty -= $stock->remaining_qty;
            //             $stock->remaining_qty = 0;
            //             $stock->save();
            //         }
            //     }

            //     $subtotal = $item['price'] * $item['qty'];
            //     $profit = $subtotal - $cost;
            //     $total += $subtotal;

            //     // 3. Simpan detail transaksi
            //     TransactionItem::create([
            //         'transaction_id' => $transaction->id,
            //         'product_id' => $item['product_id'],
            //         'qty' => $item['qty'],
            //         'selling_price' => $item['price'],
            //         'cost_price' => $cost,
            //         'profit' => $profit,
            //     ]);
            // }
            foreach ($cart as $item) {
                $product = Product::with(['stockIns', 'stockOuts'])->findOrFail($item['product_id']);
                $qty = $item['qty'];
                $price = $item['price'];
                $cost = 0;
                $subtotal = 0;
                $profit = 0;
                $amount = $item['amount'] ?? null;

                if ($product->is_flexible_amount) {
                    $fee = $item['fee'] ?? 0;

                    $cost = $amount ?? 0;
                    $subtotal = $price;
                    $profit = $fee;

                } elseif ($product->type === Product::TYPE_FISIK) {
                    $stockIns = StockIn::with('product')
                        ->where('product_id', $item['product_id'])
                        ->where('remaining_qty', '>', 0)
                        ->orderBy('expired_date', 'asc')
                        ->get();

                    foreach ($stockIns as $stock) {
                        if ($qty <= 0) {
                            break;
                        }

                        if ($stock->remaining_qty >= $qty) {
                            $cost += $qty * ($stock->product->cost_price ?? 0);
                            $stock->remaining_qty -= $qty;
                            $stock->save();
                            $qty = 0;
                        } else {
                            $cost += $stock->remaining_qty * ($stock->product->cost_price ?? 0);
                            $qty -= $stock->remaining_qty;
                            $stock->remaining_qty = 0;
                            $stock->save();
                        }
                    }

                    if ($qty > 0) {
                        throw new \Exception('Stok fisik tidak cukup saat checkout.');
                    }

                    $subtotal = $item['price'] * $item['qty'];
                    $profit = $subtotal - $cost;
                } else {
                    $cost = ($product->cost_price ?? 0) * $item['qty'];
                    $subtotal = $item['price'] * $item['qty'];
                    $profit = $subtotal - $cost;
                }

                $total += $subtotal;

                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item['product_id'],
                    'qty' => $item['qty'],
                    'amount' => $amount,
                    'selling_price' => $subtotal,
                    'cost_price' => $cost,
                    'profit' => $profit,
                ]);
            }

            // 4. Update total transaksi
            $transaction->update([
                'total_price' => $total,
            ]);

            // 5. Clear cart
            session()->forget('cart');
            DB::commit();
            return redirect('/pos/invoice/'. $transaction->id)->with('success', 'Transaksi berhasil 🔥');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
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
        $transactions = Transaction::latest()->paginate(10);
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

    private function calculateFlexibleFee(int $amount): int
    {
        return ((int) floor($amount / 1000000) + 1) * 5000;
    }

}
