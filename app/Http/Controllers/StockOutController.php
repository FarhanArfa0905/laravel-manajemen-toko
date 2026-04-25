<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockIn;
use App\Models\StockOut;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StockOutController extends Controller
{
    //

    public function index(Request $request)
    {
    $query = StockOut::with('product');

    if ($request->filled('category')) {
        $query->whereHas('product', function ($q) use ($request) {
            $q->where('category', $request->category);
        });
    }

    if ($request->filled('search')) {
        $query->whereHas('product', function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%');
        });
    }

    $stockOuts = $query->latest()->paginate(10)->withQueryString();

    return view('stock-outs.index', [
        'stockOuts' => $stockOuts,
        'categoryOptions' => Product::CATEGORY_OPTIONS[Product::TYPE_FISIK],
        'selectedCategory' => $request->category,
        'search' => $request->search,
    ]);
    }

    public function create()
    {
        $products = Product::with(['stockIns', 'stockOuts'])
            ->where('type', Product::TYPE_FISIK)
            ->orderBy('name')
            ->get();
        return view('stock-outs.create', compact('products'));
    }




    public function store(Request $request)
    {
        $request->validate([
            'product_id' => ['required', Rule::exists('products', 'id')],
            'qty' => 'required|integer|min:1',
            'note' => 'nullable|string',
        ]);

        // Validasi tolak kalau bukan fisik
        $product = Product::findOrFail($request->product_id);
        if ($product->type !== Product::TYPE_FISIK) {
            return back()->withErrors([
                'product_id' => 'Stok keluar manual hanya untuk produk fisik.',
            ])->withInput();
        }

        $qty = $request->qty;

        // hitung stock real
        $totalStock = StockIn::where('product_id', $request->product_id)
            ->sum('remaining_qty');

        if ($qty > $totalStock) {
            return back()->with('error', 'Stock tidak cukup');
        }

        // ambil batch (FEFO)
        $stockIns = StockIn::where('product_id', $request->product_id)
            ->where('remaining_qty', '>', 0)
            ->orderBy('expired_date', 'asc')
            ->get();

        foreach ($stockIns as $stock) {

            if ($qty <= 0) break;

            if ($stock->remaining_qty >= $qty) {
                $stock->remaining_qty -= $qty;
                $qty = 0;
            } else {
                $qty -= $stock->remaining_qty;
                $stock->remaining_qty = 0;
            }

            $stock->save();
        }

        // log stock out
        StockOut::create([
            'product_id' => $request->product_id,
            'qty' => $request->qty,
            'note' => $request->note,
        ]);

        return redirect('/stock-outs')->with('success', 'Stock keluar berhasil');
    }
}
