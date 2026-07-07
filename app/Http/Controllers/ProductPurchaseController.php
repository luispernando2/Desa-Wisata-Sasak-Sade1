<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductPurchaseController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validateWithBag('purchase', [
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => ['required', 'string', 'max:30', 'regex:/^\+?[0-9\s\-\.]+$/'],
            'quantity' => 'required|integer|min:1',
            'message' => 'nullable|string|max:1000',
        ], [
            'product_id.required' => 'Produk harus dipilih.',
            'product_id.exists' => 'Produk tidak ditemukan.',
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Alamat email tidak valid.',
            'phone.required' => 'Nomor WhatsApp wajib diisi.',
            'phone.max' => 'Nomor WhatsApp tidak boleh lebih dari 30 karakter.',
            'phone.regex' => 'Nomor WhatsApp hanya boleh berisi angka, spasi, plus, titik, atau strip.',
            'quantity.required' => 'Jumlah produk wajib diisi.',
            'quantity.integer' => 'Jumlah produk harus berupa angka.',
            'quantity.min' => 'Jumlah produk minimal 1.',
            'message.max' => 'Catatan tidak boleh lebih dari 1000 karakter.',
        ]);

        $product = Product::find($data['product_id']);

        if (!$product) {
            return back()->withInput()->withErrors(['product_id' => 'Produk yang dipilih tidak ditemukan.'], 'purchase');
        }

        if ($data['quantity'] > $product->stock) {
            return back()->withInput()->withErrors(['quantity' => "Jumlah produk tidak boleh lebih dari stok yang tersedia ({$product->stock})."], 'purchase');
        }

        $text = "Halo Admin Sasak Sade,\n\nSaya ingin membeli produk lokal dari Sade Mart.\n\nNama: {$data['name']}\nEmail: {$data['email']}\nPhone: {$data['phone']}\nProduk: {$product->name}\nJumlah: {$data['quantity']}\nHarga per unit: Rp" . number_format($product->price, 0, ',', '.') . "\nTotal estimasi: Rp" . number_format($product->price * $data['quantity'], 0, ',', '.') . "\nCatatan: " . ($data['message'] ?? '-') . "\n\nMohon informasi pembayaran transfer untuk pembelian ini.";
        $whatsappNumber = '6287865936972';
        $encoded = rawurlencode($text);

        return redirect()->away("https://wa.me/{$whatsappNumber}?text={$encoded}");
    }
}
