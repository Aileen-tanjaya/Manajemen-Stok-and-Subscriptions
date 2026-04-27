<?php


namespace App\Http\Controllers;


use App\Models\Stok;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;


class StokController extends Controller
{
    
    public function index()
    {
        $search = request('search');
        $status = request('status');

        $stoks = Stok::when($search, function ($query, $search) {
            return $query->where('nama_barang', 'like', "%{$search}%")
                         ->orWhere('kode_barang', 'like', "%{$search}%");
        })
        ->when($status, function ($query, $status) {
            if ($status == 'aman') {
                return $query->where('stok', '>', 5);
            } elseif ($status == 'menipis') {
                return $query->where('stok', '>', 0)->where('stok', '<=', 5);
            } elseif ($status == 'habis') {
                return $query->where('stok', '<=', 0);
            }
        })
        ->orderBy('id', 'desc')
        ->paginate(10)
        ->withQueryString();

        $totalSeluruhStok = Stok::sum('stok'); 
        $stokHabis = Stok::where('stok', '<=', 0)->count();
        $stokMenipis = Stok::where('stok', '>', 0)->where('stok', '<=', 5)->count();
        $stokAman = Stok::where('stok', '>', 5)->count();
        
        return view('stok.index', compact('stoks', 'totalSeluruhStok', 'stokHabis', 'stokMenipis', 'stokAman'));
    }


    public function create(): View
    {
        return view('stok.create');
    }


    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kode_barang' => ['required', 'string', 'max:50'],
            'nama_barang' => ['required', 'string', 'max:255'],
            'satuan'      => ['required', 'string'],
            'stok'        => ['required', 'integer'],
            'harga'       => ['required', 'numeric'],
        ]);


        Stok::create($validated);


        return Redirect::route('stok.index')->with('success', 'Stok berhasil ditambahkan.');
    }


    public function edit(Stok $stok): View
    {
        return view('stok.edit', compact('stok'));
    }


    public function update(Request $request, Stok $stok): RedirectResponse
    {
        $validated = $request->validate([
            'kode_barang' => ['required', 'string', 'max:50'],
            'nama_barang' => ['required', 'string', 'max:255'],
            'satuan'      => ['required', 'string'],
            'stok'        => ['required', 'integer'],
            'harga'       => ['required', 'numeric'],
        ]);


        $stok->update($validated);


        return Redirect::route('stok.index')->with('success', 'Stok berhasil diupdate.');
    }


    public function destroy(Stok $stok): RedirectResponse
    {
        $stok->delete();
        return Redirect::route('stok.index')->with('success', 'Stok berhasil dihapus.');
    }
}

