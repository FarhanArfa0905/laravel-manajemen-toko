<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockIn;
use Illuminate\Http\Request;

class StockInController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $stockIns = StockIn::with('product')->latest()->paginate(5);
        return view('stock-ins.index', compact('stockIns'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        // $products = Product::all();
        // Ngambil Data Barang Fisik
        $products = Product::where('type', Product::TYPE_FISIK)->get();

        return view('stock-ins.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id', 
            'qty' => 'required|integer|min:1',
            'expired_date' => 'nullable|date',
            'note' => 'nullable|string',
        ]);

        $product = Product::findOrFail($request->product_id);
        // Validasi Backend Cuman Digital yang ada Data Stok
        if ($product->type !== Product::TYPE_FISIK) {
            return back()->withErrors([
                'product_id' => 'Stok masuk hanya untuk produk fisik.'
            ])->withInput();
        }

        StockIn::create([
            'product_id' => $product->id,
            'qty' => $request->qty,
            'remaining_qty' => $request->qty,
            'expired_date' => $request->expired_date,
            'note' => $request->note,
        ]);

        return back()->with('success', 'Stok berhasil ditambahkan');
        }

    /**
     * Display the specified resource.
     */
    public function show(StockIn $stockIn)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StockIn $stockIn)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StockIn $stockIn)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StockIn $stockIn)
    {
        //
    }

    // private function rules
}
