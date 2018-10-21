<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\KeranjangBelanja;
use App\Produk;
use Auth;
use DB;

class KeranjangBelanjaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pelanggan = Auth::User()->id;
        $keranjangs = KeranjangBelanja::select('keranjang_belanjas.id','produks.nama','keranjang_belanjas.jumlah','keranjang_belanjas.harga_jual','keranjang_belanjas.subtotal')
                     ->leftJoin('produks','keranjang_belanjas.produk_id','produks.id')
                     ->where('keranjang_belanjas.pelanggan_id',$pelanggan)->where(function ($query) use ($request){
                        $query->orwhere('produks.nama', 'LIKE', '%' . $request->search . '%')
                        ->orwhere('keranjang_belanjas.jumlah', 'LIKE', '%' . $request->search . '%')
                        ->orwhere('keranjang_belanjas.harga_jual', 'LIKE', '%' . $request->search . '%')
                        ->orwhere('keranjang_belanjas.subtotal', 'LIKE', '%' . $request->search . '%');
                     })
                     ->orderBy('keranjang_belanjas.id','desc')->paginate(10);
        $data = [];

        foreach($keranjangs as $keranjang){
            $data[] = [
                    'id' => $keranjang->id,
                    'produk' => $keranjang->nama,
                    'jumlah' => number_format($keranjang->jumlah,0,',','.'),
                    'harga_jual' => number_format($keranjang->harga_jual,0,',','.'),
                    'subtotal' => number_format($keranjang->subtotal,0,',','.'),
                ];
        }

        return response()->json([
            'data' =>  app(PaginateController::class)->getPagination($keranjangs, $data, '/api/keranjangs'),
            'total' => number_format($this->getSubtotal(),0,',','.')
        ],200); 
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
            $subtotal = $jumlah_produk * $keranjangs->first()->harga_jual;
            $keranjangs->update(['jumlah' => $jumlah_produk, 'subtotal' => $subtotal]);

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

    public function getSubtotal(){
        $pelanggan = Auth::User()->id;
        return KeranjangBelanja::select([DB::raw('SUM(subtotal) as subtotal')])->where('pelanggan_id',$pelanggan)->first()->subtotal;
    }
}
