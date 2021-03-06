<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Mail;
use App\Pesanan;
use App\DetailPesanan;

class Pesanan extends Model
{
    protected $fillable = [
        'pelanggan_id', 'total', 'metode_pembayaran', 'status_pesanan','alasan_batal','catatan','kas_id','bukti_pembayaran'
    ];

    public function pelanggan()
    {
        return $this->hasOne('App\User', 'id', 'pelanggan_id');
    }

    public function bank()
    {
        return $this->hasOne('App\Bank', 'id', 'kas_id');
    }

    public function detail_pesanan(){
        return $this->hasMany('App\DetailPesanan','pesanan_id','id');
    }

    public function getTanggalAttribute() {
        $tanggal = date($this->created_at);
        $date = date_create($tanggal);
        $date_terbalik = date_format($date, "Y-m-d");
        return $this->tanggal_indo($date_terbalik);
    }

    public function tanggal_indo($tanggal){
        $bulan = array (1 =>   'Januari',
                    'Februari',
                    'Maret',
                    'April',
                    'Mei',
                    'Juni',
                    'Juli',
                    'Agustus',
                    'September',
                    'Oktober',
                    'November',
                    'Desember'
                );
        $split = explode('-', $tanggal);
        return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
    }

    public function scopeQueryPesanan($query,$request){
            $query->select('pesanans.id as id','users.name as pelanggan','pesanans.created_at as waktu','pesanans.total as total','pesanans.status_pesanan as status_pesanan')
                    ->leftJoin('users','pesanans.pelanggan_id','users.id')
                    ->where(function ($query) use ($request){
                        $query->orWhere('users.name', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('pesanans.total', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('pesanans.metode_pembayaran', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('pesanans.alasan_batal', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('pesanans.catatan', 'LIKE', '%' . $request->search . '%');
                    });
        return $query;
    }

    public function sendMailPesananBaru($request){

        $pesanan = $this;
        $detail_pesanan = DetailPesanan::with('produk')->where('pesanan_id',$pesanan->id)->get();

        Mail::send('mails.pesanan_baru', compact('pesanan','detail_pesanan'), function ($message) use ($pesanan, $request) {
              $message->from('nicofachreza@gmail.com');
              $message->to($request->email);
              $message->subject('Pesanan Anda Telah Kami Terima');
        });

        return true;

        /*
        $id_pesanan = $pesanan->id;

        Mail::send('mails.notifikasi_admin', compact('id_pesanan'), function ($message) {
              $message->from('ibnmp10@gmail.com','Aqiqah Lampung');
              $message->to("rindangramadhan10@gmail.com");
              $message->subject('Ada Pesanan baru');
        });
        */

    }
}
