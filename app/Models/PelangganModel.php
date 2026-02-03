<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PelangganModel extends Model
{
    protected $table = 'pelanggan';
    protected $fillable = [
        'nama_pelanggan',
        'alamat',
        'telpon',
    ];
     public function transaksi()
    {
        return $this->hasMany(TranModel::class, 'id_pelanggan'); 
    }
}
