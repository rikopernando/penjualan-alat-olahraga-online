<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\KeranjangBelanja;
use App\Produk;
use Auth;

class KeranjangBelanjaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keranjangs = KeranjangBelanja::select('id','pelanggan_id','produk_id','jumlah','harga_jual','subtotal')
                     ->with(['produk','pelanggan'])->where(function ($query) use ($request){
                        $query->orwhere('pelanggan_id', 'LIKE', '%' . $request->search . '%')
                        ->orwhere('produk_id', 'LIKE', '%' . $request->search . '%')
                        ->orwhere('jumlah', 'LIKE', '%' . $request->search . '%')
                        ->orwhere('harga_jual', 'LIKE', '%' . $request->search . '%')
                        ->orwhere('subtotal', 'LIKE', '%' . $request->search . '%');
                     })
                     ->orderBy('id','desc')->paginate(10);
        $data = [];

        foreach($keranjangs as $keranjang){
            $data[] = [
                    'id' => $keranjang->id,
                    'pelanggan_id' => $keranjang->pelanggan_id,
                    'pelanggan' => $keranjang->pelanggan->name,
                    'produk' => $keranjang->produk->nama,
                    'produk_id' => $keranjang->produk_id,
                    'jumlah' => number_format($keranjang->jumlah,0,',','.'),
                    'harga_jual' => number_format($keranjang->harga_jual,0,',','.'),
                    'subtotal' => number_format($keranjang->subtotal,0,',','.'),
                ];
        }

        return app(PaginateController::class)->getPagination($keranjangs, $data, '/api/keranjangs');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $produk = Produk::select('harga_jual')->whereId($request->produk)->first();

        $keranjangs = KeranjangBelanja::where('pelanggan_id',Auth::User()->id)->where('produk_id',$request->produk);

        if($keranjangs->count() > 0){
            $jumlah_produk = $keranjangs->first()->jumlah + $request->jumlah;
            $keranjangs->update(['jumlah' => $jumlah_produk]);

            return response()->json([
                'message' => 'Success Create Keranjang',
                'data' => $keranjangs->first(),
                'jumlah' => 0
            ],200);
        }else{
            $keranjangs = KeranjangBelanja::create([
                'pelanggan_id' => Auth::User()->id,
                'produk_id' => $request->produk,
                'jumlah' => $request->jumlah,
                'harga_jual' => $produk->harga_jual,
                'subtotal' => $request->jumlah * $produk->harga_jual
            ]);

            return response()->json([
                'message' => 'Success Create Keranjang',
                'data' => $keranjangs,
                'jumlah' => 1
            ],200);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $keranjang = KeranjangBelanja::select('id','pelanggan_id','produk_id','jumlah','harga_jual','subtotal')
                     ->with(['produk','pelanggan'])->whereId($id)->first();

        return response()->json([
            'id' => $keranjang->id,
            'pelanggan_id' => $keranjang->pelanggan_id,
            'pelanggan' => $keranjang->pelanggan->name,
            'produk' => $keranjang->produk->nama,
            'produk_id' => $keranjang->produk_id,
            'jumlah' => number_format($keranjang->jumlah,0,',','.'),
            'harga_jual' => number_format($keranjang->harga_jual,0,',','.'),
            'subtotal' => number_format($keranjang->subtotal,0,',','.'),
        ],200);
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
        $keranjangs = KeranjangBelanja::find($id)->update(['jumlah' => $request->jumlah]);

        return response()->json([
            'message' => 'Success Edit Keranjang',
            'data' => $keranjangs
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return KeranjangBelanja::destroy($id);
    }
}
