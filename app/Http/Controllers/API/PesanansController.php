<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use App\Pesanan;
use App\DetailPesanan;
use App\KeranjangBelanja;
use App\User;

class PesanansController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pesanans = Pesanan::select('pesanans.id as id','users.name as pelanggan','pesanans.created_at as waktu','pesanans.total as total','pesanans.status_pesanan as status_pesanan')
            ->leftJoin('users','pesanans.pelanggan_id','users.id')
            ->where(function ($query) use ($request){
                $query->orWhere('users.name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('pesanans.total', 'LIKE', '%' . $request->search . '%')
                ->orWhere('pesanans.metode_pembayaran', 'LIKE', '%' . $request->search . '%')
                ->orWhere('pesanans.alasan_batal', 'LIKE', '%' . $request->search . '%')
                ->orWhere('pesanans.catatan', 'LIKE', '%' . $request->search . '%');
            })->orderBy('pesanans.id','desc')->paginate(10);
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

        return app(PaginateController::class)->getPagination($pesanans, $data, '/api/pesanans');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pelanggan = Auth::User()->id;
        $total = str_replace(".","",$request->total);
        $this->validate($request,[
            'nama' => 'required|string',
            'alamat' => 'required',
            'email' => 'required|string|email|max:255|unique:users,id,'.$pelanggan,
            'no_telp' => 'required',
            'kabupaten' => 'required',
            'kecamatan' => 'required',
            'kelurahan' => 'required'
        ]);  

        DB::beginTransaction();

        try {

            $user = User::find($pelanggan);
            $user->update([
                'name' => $request->nama,
                'no_telp' => $request->no_telp,
                'email' => $request->email,
                'alamat' => $request->alamat,
                'provinsi' => 18,
                'kabupaten' => $request->kabupaten,
                'kecamatan' => $request->kecamatan,
                'kelurahan' => $request->kelurahan
            ]);

            if(!$user){
                DB::rollBack();
                return response()->json([
                  'message' => 'Terjadi kesalahan saat memproses data',
                   'status' => 2
                ],200); 
            }
            
            $pesanan = Pesanan::create([
               'pelanggan_id' => $pelanggan,
               'total' => $total,
               'metode_pembayaran' => 'TRANSFER',
               'status_pesanan' => 0,
               'kas_id' => $request->bank,
               'catatan' => $request->catatan
            ]);

            if(!$pesanan){
                DB::rollBack();
                return response()->json([
                  'message' => 'Terjadi kesalahan saat memproses data',
                   'status' => 2
                ],200); 
            }

            if($total == 0){
		      DB::rollBack();
              return response()->json([
                'message' => 'Anda belum melakukan Transaksi',
                'status' => 1
              ],200); 
            }
		

            $keranjang = KeranjangBelanja::where('pelanggan_id',$pelanggan);

            if($keranjang->count() > 0){
                foreach($keranjang->get() as $data) {
                    $detail_pesanan = DetailPesanan::create([
                        'pesanan_id' => $pesanan->id,
                        'produk_id' => $data->produk_id,
                        'jumlah' => $data->jumlah,
                        'harga_jual' => $data->harga_jual,
                        'subtotal' => $data->subtotal
                    ]);
                    if(!$detail_pesanan){
		                DB::rollBack();
                        return response()->json([
                          'message' => 'Terjadi kesalahan saat memproses data',
                           'status' => 2
                        ],200); 
                    }
                }
            }else{
		      DB::rollBack();
              return response()->json([
                'message' => 'Anda belum melakukan Transaksi',
                'status' => 1
              ],200); 
            }

          $keranjang->delete();
          DB::commit();
          return response()->json([
            'message' => 'Transaksi Berhasil',
            'status' => 3
          ],200); 
        }
		catch (Exception $err){
		  DB::rollBack();
		  return response()->json([
			'error' => $err 
		  ],500); 
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
        return Pesanan::select('pesanans.id as id','users.name as pelanggan','pesanans.created_at as waktu','pesanans.total as total','pesanans.status_pesanan as status_pesanan')
            ->leftJoin('users','pesanans.pelanggan_id','users.id')
            ->where('pesanans.id',$id)->first();
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
        $pesanan = Pesanan::destroy($id);
        $detail_pesanan = DetailPesanan::where('pesanan_id',$id)->delete();

        return response(200);
    }
}
