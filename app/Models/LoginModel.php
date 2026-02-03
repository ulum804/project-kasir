<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
// use Illuminate\Database\Eloquent\Model;
use App\Models\BarangModel;

class LoginModel extends Authenticatable
{
    protected $table = 'admin';
    protected $primaryKey = 'id_admin';
    public $timestamps = true;   

    protected $fillable = [
        'username',
        'password'
    ];

    protected $hidden = [
        'password'
    ];

    public function barang()
    {
        return $this->hasMany(BarangModel::class, 'id_admin', 'id_admin');
    }
}
