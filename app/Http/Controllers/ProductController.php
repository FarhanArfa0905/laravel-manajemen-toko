<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    public function index()
    {
        return view ('products.index', [
            'title' => 'Products',
            'products' => Product::with(['stockIns', 'stockOuts'])->latest()->paginate(5),
            // 'products' => Product::latest()->paginate(5)
        ]);
    }

    public function create()
    {
        return view('products.create', [
            'typeLabels' => Product::TYPE_LABELS,
            'categoryOptions' => Product::CATEGORY_OPTIONS,
        ]);
    }

    public function store(Request $request) 
    {
        $validated = $request->validate($this->rules(), $this->messages());
        $this->ensureCategoryMatchesType($validated['type'], $validated['category']);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'name' => $validated['name'],
            'code' => $this->generateProductCode(
                $validated['type'],
                $validated['category'],
                $validated['code'] ?? null
            ),
            'type' => $validated['type'],
            'category' => $validated['category'],
            'provider' => $validated['provider'] ?? null,
            'price' => $validated['price'],
            'cost_price' => $validated['type'] === Product::TYPE_FISIK
                ? $validated['cost_price']
                : ($validated['cost_price'] ?? null),
            'image' => $imagePath,
        ]);

        return redirect('/products')->with('success', 'Product Created');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);

        return view('products.edit', [
            'product' => $product,
            'typeLabels' => Product::TYPE_LABELS,
            'categoryOptions' => Product::CATEGORY_OPTIONS,
        ]);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $validated = $request->validate($this->rules($product->id), $this->messages());
        $this->ensureCategoryMatchesType($validated['type'], $validated['category']);

        $imagePath = $product->image;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'name' => $validated['name'],
            'code' => $this->generateProductCode(
                $validated['type'],
                $validated['category'],
                $validated['code'] ?? null,
                $product->id
            ),
            'type' => $validated['type'],
            'category' => $validated['category'],
            'provider' => $validated['provider'] ?? null,
            'price' => $validated['price'],
            'cost_price' => $validated['type'] === Product::TYPE_FISIK
                ? $validated['cost_price']
                : ($validated['cost_price'] ?? null),
            'image' => $imagePath,
        ]);

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
        $product = Product::with(['stockIns' => function($q){
            $q->orderBy('expired_date', 'asc');
        }])->findOrFail($id);

        return view('products.detail', compact('product'));
    }

    private function rules(?int $productId = null): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'code' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('products', 'code')->ignore($productId),
            ],
            'type' => ['required', Rule::in(array_keys(Product::TYPE_LABELS))],
            'category' => [
                'required',
                Rule::in(Product::availableCategories()),
            ],
            'provider' => ['nullable', 'required_if:type,' . Product::TYPE_DIGITAL, 'string',  'max:100'],
            'price' => ['required', 'integer', 'min:0'],
            'cost_price' => ['nullable', 'required_if:type,' . Product::TYPE_FISIK, 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }

    private function messages(): array
    {
        return [
            'name.required' => 'Nama produk wajib diisi.',
            'code.unique' => 'Kode produk sudah dipakai, gunakan kode lain.',
            'type.required' => 'Tipe produk wajib dipilih.',
            'type.in' => 'Tipe produk tidak valid.',
            'category.required' => 'Kategori produk wajib dipilih.',
            'category.in' => 'Kategori produk tidak valid.',
            'price.required' => 'Harga jual wajib diisi.',
            'price.integer' => 'Harga jual harus berupa angka.',
            'price.min' => 'Harga jual tidak boleh minus.',
            'cost_price.required_if' => 'Harga modal wajib diisi untuk produk fisik.',
            'cost_price.integer' => 'Harga modal harus berupa angka.',
            'cost_price.min' => 'Harga modal tidak boleh minus.',
            'image.max' => 'Ukuran gambar maksimal 2 MB.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus JPG, JPEG, atau PNG.',
            'provider.required_if' => "Provider wajib diisi untuk produk digital",
            'provider.string' => 'Provider harus berupa teks',
            'provider.max' => 'Provider maksimal 100 karakter'
        ];
    }

    private function generateProductCode(string $type, string $category, ?string $manualCode = null, ?int $ignoreId = null): string
    {
        $manualCode = trim((string) $manualCode);

        if ($manualCode !== '') {
            return strtoupper($manualCode);
        }
        $typePrefix = $type === Product::TYPE_FISIK ? 'FSK' : 'DGT';
        $categoryPrefix = strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $category), 0, 3) ?: 'PRD');
        do {
            $generatedCode = $typePrefix . '-' . $categoryPrefix . '-' . now()->format('dmy') . '-' . random_int(100, 999);
        } while (
            Product::query()
                ->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))
                ->where('code', $generatedCode)
                ->exists()
        );
        return $generatedCode;
    }

    private function ensureCategoryMatchesType(string $type, string $category): void
    {
        if (! array_key_exists($category, Product::CATEGORY_OPTIONS[$type] ?? [])) {
            throw ValidationException::withMessages([
                'category' => 'Kategori tidak sesuai dengan tipe produk yang dipilih.',
            ]);
        }
    }
}
