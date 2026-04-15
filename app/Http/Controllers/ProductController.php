<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    public function index()
    {
        return view ('products.index', [
            'title' => 'Products',
            'products' => Product::latest()->paginate(5)
        ]);
    }

    public function create()
    {
        return view ('products.create'
            // 'title' => 'Products',
            // 'products' => Product::latest()->get()
        );
    }

    public function store(Request $request) 
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|integer|gte:cost_price',
            'cost_price' => 'required|integer',
            // 'stock' => 'required|integer'
        ],[
            'name.required' => 'Nama Produk Wajib Diisi',
            'price.required' => 'Harga Produk Wajib Diisi',
            'price.integer' => 'Harga Produk Wajib Angka',
            'price.gte' => 'Harga Produk Tidak boleh kurang dari harga modal',
            'cost_price.required' => 'Biaya Produk Wajib Diisi',
            'cost_price.integer' => 'Biaya Produk Wajib Angka',
            // 'stock.required' => 'Stock Produk Wajib Diisi',
            // 'stock.integer' => 'Stock Produk Wajib Angka'
        ]);

        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'cost_price' => $request->cost_price,
            // 'stock' => $request->stock,
        ]);

        return redirect('/products')->with('success', 'Product Created');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
        // dd($product);
    }

    public function update(Request $request, $id)
    {
        $validated =  $request->validate([
            'name' => 'required',
            'price' => 'required|integer|gte:cost_price',
            'cost_price' => 'required|integer',
            // 'stock' => 'required|integer'
        ],[ 
            'name.required' => 'Nama Produk Wajib Diisi',
            'price.required' => 'Harga Produk Wajib Diisi',
            'price.integer' => 'Harga Produk Wajib Angka',
            'cost_price.required' => 'Biaya Produk Wajib Diisi',
            'cost_price.integer' => 'Biaya Produk Wajib Angka',
            'price.gte' => 'Harga Produk Tidak boleh kurang dari harga modal',
            // 'stock.required' => 'Stock Produk Wajib Diisi',
            // 'stock.integer' => 'Stock Produk Wajib Angka'
        ]);

        $product = Product::findOrFail($id);
        $product->update($validated);

        return redirect('/products')->with('success', 'Product Updated');
    }

    public function delete(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect('/products')->with('success', 'Product Deleted');
    }

    public function show($id)
    {
        // $product = Product::with('stockIns')->findOrFail($id);
        $product = Product::with(['stockIns' => function($q){
            $q->orderBy('expired_date', 'asc');
        }])->findOrFail($id);

        return view('products.detail', compact('product'));
    }
}
