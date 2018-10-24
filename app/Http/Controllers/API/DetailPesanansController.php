<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DetailPesanan;

class DetailPesanansController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $detail_pesanans = DetailPesanan::select('detail_pesanans.id as id','detail_pesanans.jumlah as jumlah','detail_pesanans.harga_jual as harga_jual','detail_pesanans.subtotal as subtotal','produks.nama as nama_produk')
            ->leftJoin('produks','detail_pesanans.produk_id','produks.id')
            ->where(function($query) use ($request){
					$query->orwhere('produks.nama', 'LIKE', '%' . $request->search . '%')
					->orwhere('detail_pesanans.harga_jual', 'LIKE', '%' . $request->search . '%')
					->orwhere('detail_pesanans.jumlah', 'LIKE', '%' . $request->search . '%');
                })
            ->where('detail_pesanans.pesanan_id',$request->id)
            ->orderBy('detail_pesanans.id','desc')->paginate(10);
        $data = [];

        foreach($detail_pesanans as $produk){
            $data[] = [
                    'id' => $produk->id,
                    'nama_produk' => $produk->nama_produk,
                    'harga_jual' => number_format($produk->harga_jual,0,',','.'),
                    'jumlah' => $produk->jumlah,
                    'subtotal' => number_format($produk->subtotal,0,',','.'),
                ];
        }

        return app(PaginateController::class)->getPagination($detail_pesanans, $data, '/api/detail-pesanans/');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
