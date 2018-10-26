<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Pesanan;
use App\DetailPesanan;

class PesananSayaController extends Controller
{
    //
    public function index(Request $request){
        $me = Auth::User()->id;
        $pesanans = Pesanan::QueryPesanan($request)->where('pesanans.pelanggan_id',$me)->orderBy('pesanans.id','desc')->paginate(10);
        $data = [];

        foreach($pesanans as $pesanan){
            $data[] = [
                    'id' => $pesanan->id,
                    'pelanggan' => $pesanan->pelanggan,
                    'waktu' => $pesanan->waktu,
                    'total' => number_format($pesanan->total,0,',','.'),
                    'status_pesanan' => $pesanan->status_pesanan,
                ];
        }

        return app(PaginateController::class)->getPagination($pesanans, $data, '/api/pesanan-saya');

    }
}
