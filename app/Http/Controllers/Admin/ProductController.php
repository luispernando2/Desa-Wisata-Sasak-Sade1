<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Product;
use App\Traits\LogActivity;
use Illuminate\Http\Request;

class ProductController extends AdminController
{
    use LogActivity;

    public function index()
    {
        return view('admin.products.index', ['products' => Product::orderBy('name')->get()]);
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $data['image_path'] = $imagePath;
        }

        $product = Product::create($data);

        $this->logActivity(
            'create',
            'products',
            "Produk '{$data['name']}' ditambahkan",
            $product->id,
            null,
            $data
        );

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image_path && \Storage::disk('public')->exists($product->image_path)) {
                \Storage::disk('public')->delete($product->image_path);
            }
            $imagePath = $request->file('image')->store('products', 'public');
            $data['image_path'] = $imagePath;
        }

        $oldValues = $product->toArray();
        $product->update($data);

        $this->logActivity(
            'update',
            'products',
            "Produk '{$product->name}' diperbarui",
            $product->id,
            $oldValues,
            $data
        );

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $productName = $product->name;
        $productId = $product->id;
        $oldValues = $product->toArray();

        if ($product->image_path && \Storage::disk('public')->exists($product->image_path)) {
            \Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        $this->logActivity(
            'delete',
            'products',
            "Produk '{$productName}' dihapus",
            $productId,
            $oldValues,
            null
        );

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
