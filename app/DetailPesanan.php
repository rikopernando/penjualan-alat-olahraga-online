<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    protected $fillable = [
        'pesanan_id', 'produk_id', 'jumlah', 'harga_jual','subtotal', 'warna'
    ];

    public function produk()
    {
        return $this->hasOne('App\Produk', 'id', 'produk_id');
    }
}
