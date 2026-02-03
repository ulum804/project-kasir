<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class StrukController extends Controller
{
   public function download($kode)
    {
        $transaksi = DB::table('tranksaksi')
            ->join('pelanggan', 'tranksaksi.id_pelanggan', '=', 'pelanggan.id')
            ->join('barang', 'tranksaksi.id_produk', '=', 'barang.id_barang')
            ->where('tranksaksi.kode_transaksi', $kode)
            ->select(
                'tranksaksi.*',
                'pelanggan.nama_pelanggan',
                'barang.nama_barang',
                'barang.harga'
            )
            ->get();

        if ($transaksi->isEmpty()) {
            abort(404, 'Transaksi tidak ditemukan');
        }

        $pdf = Pdf::loadView('kasir.struk', [
            'transaksi' => $transaksi,
            'tanggal'   => now()->format('d-m-Y H:i')
        ]);

        return $pdf->download('struk-'.$kode.'.pdf');
    }
}
