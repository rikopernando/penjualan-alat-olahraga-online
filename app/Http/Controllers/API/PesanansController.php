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
        $pesanans = Pesanan::QueryPesanan($request)->orderBy('pesanans.id','desc')->paginate(10);
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
        DB::beginTransaction();
        $pelanggan = $request->id;
        $total = str_replace(".","",$request->total);
        $this->validate($request,[
            'nama' => 'required|string',
            'alamat' => 'required',
            'email' => 'required|string|email|max:255|unique:users,id,'.$pelanggan,
            'no_telp' => 'required',
            'kabupaten' => 'required',
            'kecamatan' => 'required',
            'kelurahan' => 'required',
            'bank' => 'required',
            'atas_nama' => 'required',
            'no_rek' => 'required'
        ]);  

        try {

            $user = User::find($pelanggan);
            $user_update = [
                'name' => $request->nama,
                'no_telp' => $request->no_telp,
                'alamat' => $request->alamat,
                'provinsi' => 18,
                'kabupaten' => $request->kabupaten,
                'kecamatan' => $request->kecamatan,
                'kelurahan' => $request->kelurahan
            ];
            if($user->email != $request->email){
                $user_update["email"] = $request->email;
            }
            $user->update($user_update);

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
          /*if(!$pesanan->sendMailPesananBaru()){
            DB::rollBack();
          }*/
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
        $pesanan = Pesanan::select('pesanans.id as id','users.name as pelanggan','pesanans.created_at as waktu','pesanans.total as total','pesanans.status_pesanan as status_pesanan','banks.name as bank_transfer','pesanans.bukti_pembayaran as bukti_pembayaran','users.alamat as alamat')
            ->leftJoin('users','pesanans.pelanggan_id','users.id')
            ->leftJoin('banks','pesanans.kas_id','banks.id')
            ->where('pesanans.id',$id)->first();

        $status_pesanan = $this->statusPesanan($pesanan->status_pesanan);

        $pesanan->bukti_pembayaran ? $bukti_pembayaran = url('image_bukti_bayar/'.$pesanan->bukti_pembayaran) : $bukti_pembayaran = null;

        return response()->json([
            'id' => $pesanan->id,
            'pelanggan' => $pesanan->pelanggan,
            'alamat' => $pesanan->alamat,
            'total' => number_format($pesanan->total,0,',','.'),
            'status_pesanan' => $status_pesanan->original['status'],
            'waktu' => $pesanan->waktu,
            'bank_transfer' => $pesanan->bank_transfer,
            'button_status' => $status_pesanan->original['button_status'],
            'bukti_pembayaran' => $bukti_pembayaran,
            'status' => $pesanan->status_pesanan == 4 ? 2 : $pesanan->status_pesanan + 1
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
        //
        $pesanan = Pesanan::find($id)->update(['status_pesanan' => $request->status_pesanan]);
        $status_pesanan = $this->statusPesanan($request->status_pesanan);

        return $status_pesanan;
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

    public function statusPesanan($status_pesanan){
        switch ($status_pesanan):
            case 0:
            $status = "Pesanan Baru, Pelanggan Belum Mengkonfirmasi Pembayaran";
            $button_status = "Terima Pembayaran";
        break;
            case 1:
            $status = "Pesanan Telah Di Konfirmasi";
            $button_status = "Proses Pesanan";
        break;
            case 2:
            $status = "Pesanan Sedang Di Proses";
            $button_status = "Selesaikan Pesanan";
        break;
            case 3:
            $status = "Pesanan Telah Selesai";
            $button_status = "Pesanan Selesai";
        break;
            case 4:
            $status = "Pesanan Dibatalkan";
            $button_status = "Tidak Jadi Batal ?";
        break;
        endswitch;


        return response()->json([
            'status' => $status,
            'button_status' => $button_status
        ]);
    }

    public function filter(Request $request){

        $pesanans = Pesanan::QueryPesanan($request)
		   	->where(DB::raw('DATE(pesanans.created_at)'), '>=', $request->dari_tanggal)
			->where(DB::raw('DATE(pesanans.created_at)'), '<=', $request->sampai_tanggal)
            ->orderBy('pesanans.id','desc')->paginate(10);
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

        return app(PaginateController::class)->getPagination($pesanans, $data, '/api/pesanans-filter');
    }

    public function cetak(Request $request){

        $pesanans = Pesanan::QueryPesanan($request)
		   	->where(DB::raw('DATE(pesanans.created_at)'), '>=', $request->dari_tanggal)
			->where(DB::raw('DATE(pesanans.created_at)'), '<=', $request->sampai_tanggal)
            ->orderBy('pesanans.id','desc')->get();
        $data = [];
        $total = 0;

        foreach($pesanans as $pesanan){
            $status_pesanan = $this->statusPesanan($pesanan->status_pesanan);
            $total += $pesanan->total;
            $data[] = [
                    'id' => $pesanan->id,
                    'pelanggan' => $pesanan->pelanggan,
                    'waktu' => $pesanan->waktu,
                    'total' => number_format($pesanan->total,0,',','.'),
                    'status_pesanan' => $status_pesanan->original['status'],
                ];
        }

    	return view('penjualan.cetak', [
                'penjualan' => $data,
                'dari_tanggal' => $request->dari_tanggal,
                'sampai_tanggal' => $request->sampai_tanggal,
                'total' => number_format($total,0,',','.')
        ])->with(compact('html'));
    }
}
