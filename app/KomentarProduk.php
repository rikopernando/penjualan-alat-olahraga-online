<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KomentarProduk extends Model
{
    protected $fillable = [
        'pelanggan_id', 'produk_id', 'komentar'
    ];

    public function pelanggan()
    {
        return $this->hasOne('App\User', 'id', 'pelanggan_id');
    }
}
