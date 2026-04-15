<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockIn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockInController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $stockIns = StockIn::with('product')->latest()->get();
        return view('stock-ins.index', compact('stockIns'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $products = Product::all();

        return view('stock-ins.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // dd(DB::connection()->getDatabaseName());
        $request->validate([
            'product_id' => 'required|exists:products,id', 
            'qty' => 'required|integer|min:1',
            'expired' => 'nullable|date',
        ]);

        $product = Product::findOrFail($request->product_id);

        StockIn::create([
            'product_id' => $product->id,
            'qty' => $request->qty,
            'remaining_qty' => $request->qty,
            'expired_date' => $request->expired_date,
            'note' => $request->note,
        ]);

        $product->stock += $request->qty;
        $product->save();

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
}
