<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Menampilkan daftar semua barang.
     */
    public function index(): View
    {
        $products = Product::orderBy('id', 'desc')->paginate(10);

        return view('products.index', [
            'products' => $products,
        ]);
    }

    /**
     * Menampilkan form untuk menambah barang baru.
     */
    public function create(): View
    {
        return view('products.create');
    }

    /**
     * Menyimpan barang baru ke database (Sudah pakai kode_barang dan satuan).
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kode_barang' => ['required', 'string', 'max:50'],
            'nama_barang' => ['required', 'string', 'max:255'],
            'satuan'      => ['required', 'string', 'max:50'],
            'harga'       => ['required', 'numeric'],
        ]);

        // REKAM USER: Otomatis menyimpan ID admin yang sedang menambahkan barang
        $validated['user_id'] = auth()->id();

        Product::create($validated);

        return Redirect::route('products.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit untuk barang tertentu.
     */
    public function edit(Product $product): View
    {
        return view('products.edit', [
            'product' => $product
        ]);
    }

    /**
     * Memperbarui data barang di database (Sudah pakai kode_barang dan satuan).
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'kode_barang' => ['required', 'string', 'max:50'],
            'nama_barang' => ['required', 'string', 'max:255'],
            'satuan'      => ['required', 'string', 'max:50'],
            'harga'       => ['required', 'numeric'],
        ]);

        // REKAM USER: Otomatis memperbarui ID admin terakhir yang mengedit barang
        $validated['user_id'] = auth()->id();

        $product->update($validated);

        return Redirect::route('products.index')->with('success', 'Barang berhasil diupdate.');
    }

    /**
     * Menghapus barang dari database.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return Redirect::route('products.index')->with('success', 'Barang berhasil dihapus.');
    }
}