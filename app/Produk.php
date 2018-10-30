<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $fillable = [
        'nama', 'harga_jual', 'deskripsi', 'foto','stok','warna'
    ];
}
