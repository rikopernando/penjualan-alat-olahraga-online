<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KeranjangBelanja extends Model
{
    protected $fillable = [
        'pelanggan_id', 'produk_id', 'jumlah', 'harga_jual','subtotal'
    ];

    public function produk()
    {
        return $this->hasOne('App\Produk', 'id', 'produk_id');
    }

    public function pelanggan()
    {
        return $this->hasOne('App\User', 'id', 'pelanggan_id');
    }
}
