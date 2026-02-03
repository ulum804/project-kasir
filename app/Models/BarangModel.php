<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\LoginModel;

class BarangModel extends Model
{
    use HasFactory;

    protected $table = 'barang';
    protected $primaryKey = 'id_barang';

    protected $fillable = [
        'id_admin',
        'nama_barang',
        'kategori',
        'stok',
        'harga',
    ];

    /**
     * Relasi ke admin
     */
    public function admin()
    {
        return $this->belongsTo(LoginModel::class, 'id_admin', 'id_admin');
    }
}
