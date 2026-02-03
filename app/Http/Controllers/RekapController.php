<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class RekapController extends Controller
{
    public function index ()
    {
        // Rekap harian
        $harian = DB::table('tranksaksi')
            ->select(
                'tanggal',
                DB::raw('COUNT(DISTINCT id_pelanggan) as total_transaksi'),
                DB::raw('SUM(jumlah) as total_produk'),
                DB::raw('SUM(subtotal) as total_pendapatan')
            )
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'desc')
            ->get();

        $bulanan = DB::table('tranksaksi')
            ->select(
                DB::raw("DATE_FORMAT(tanggal, '%Y-%m') as bulan"),
                DB::raw('COUNT(DISTINCT id_pelanggan) as total_transaksi'),
                DB::raw('SUM(jumlah) as total_produk'),
                DB::raw('SUM(subtotal) as total_pendapatan')
            )
            ->groupBy(DB::raw("DATE_FORMAT(tanggal, '%Y-%m')"))
            ->orderBy('bulan', 'desc')
            ->get();

        return view('kasir.dashboard', compact('harian', 'bulanan'));
    }
}
