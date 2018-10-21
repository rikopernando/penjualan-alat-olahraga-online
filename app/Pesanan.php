<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $fillable = [
        'pelanggan_id', 'total', 'metode_pembayaran', 'status_pesanan','alasan_batal','catatan'
    ];

    public function pelanggan()
    {
        return $this->hasOne('App\User', 'id', 'pelanggan_id');
    }
}
