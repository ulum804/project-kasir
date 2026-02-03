<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BarangController extends Controller
{
     /**
     * Tampilkan halaman produk
     */
    public function index()
    {
        $barang = BarangModel::all();
        $keranjang = session()->get('keranjang', []);
        // $total = collect($keranjang)->sum(fn($i) => $i['harga'] * $i['qty']);

        return view('kasir.produk', compact('barang'));
    }

    /**
     * Simpan produk baru
     */
   public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kategori'    => 'required|in:makanan,minuman',
            'stok'        => 'required|integer|min:0',
            'harga'       => 'required|integer|min:0',
        ]);

        BarangModel::create([
            'id_admin'    => 1, // atau 1
            'nama_barang' => $request->nama_barang,
            'kategori'    => $request->kategori,
            'stok'        => $request->stok,
            'harga'       => $request->harga,
        ]);

        return redirect()->route('produk.index')
            ->with('success', 'Produk berhasil ditambahkan');
    }
       public function edit($id)
    {
        
        $barang = BarangModel::where('id_barang', $id)->firstOrFail();
        return view('kasir.produk_edit', compact('barang'));
    }
      public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required',
            'kategori'    => 'required|in:makanan,minuman',
            'stok'        => 'required|integer',
            'harga'       => 'required|integer',
        ]);

        BarangModel::where('id_barang', $id)->update([
            'nama_barang' => $request->nama_barang,
            'kategori'    => $request->kategori,
            'stok'        => $request->stok,
            'harga'       => $request->harga,
        ]);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diupdate');
    }

    /**
     * Hapus produk
     */
    public function destroy($id)
    {
        BarangModel::where('id_barang', $id)->delete();
        return redirect()->back()->with('success', 'Produk berhasil dihapus');
    }
}
