<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    protected $table = 'kendaraan';
    protected $primaryKey = 'id';

    public function pesanans()
    {
        return $this->hasMany(Pesanan::class, 'kendaraan_id', 'id');
    }
    //method untuk mengambil kendaraan berdasarkan kategori
    public static function ambilKategori($kategori)
    {
        return self::where('kategori_id', $kategori)
            ->where('status', 'tersedia')
            ->get();
    }

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class);
    }
}
