<?php
namespace App\Http\Controllers;

use App\Models\PelangganModel;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index()
    {
        // Ambil semua pelanggan dari database
        $pelanggan = PelangganModel::all();

        // Kirim ke view
        return view('kasir.rekap', compact('pelanggan'));
    }
       public function destroy($id)
    {
        PelangganModel::where('id', $id)->delete();
        return redirect()->back()->with('success', 'data berhasil dihapus');
    }
}
