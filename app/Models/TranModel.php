<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TranModel extends Model
{
    protected $table = 'tranksaksi';
    protected $primaryKey = 'id_tranksaksi';

    protected $fillable = [
        'id_pelanggan',
        'id_produk',
        'kode_transaksi', // 👈 TAMBAHAN
        'jumlah',
        'subtotal',
        'total',
        'tanggal',
    ];

    /* RELASI */

    // ke produk / barang
    public function produk()
    {
        return $this->belongsTo(BarangModel::class, 'id_produk', 'id_barang');
    }

    // ke pelanggan
    public function pelanggan()
    {
        return $this->belongsTo(PelangganModel::class, 'id_pelanggan');
    }
    
}
