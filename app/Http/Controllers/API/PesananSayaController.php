<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Pesanan;
use App\DetailPesanan;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\File;

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

    public function uploadBuktiPembayaran(Request $request){

        $this->validate($request,[
            'bukti_pembayaran' => 'image|max:3072'
        ]);  

        $pesanan = Pesanan::find($request->id);	

        if($request->hasFile('bukti_pembayaran')){
            $bukti_pembayaran = $request->file('bukti_pembayaran');
            $this->deleteFile($pesanan->bukti_pembayaran,'image_bukti_bayar');
            $pesanan->bukti_pembayaran = $this->uploadFile($bukti_pembayaran);
            $pesanan->save();
        }

        return response()->json([
            'message' => 'Success Upload Bukti Pembayaran',
            'data' => $pesanan
        ],200);
    }

    public function uploadFile($file) {
        if (is_array($file) || is_object($file)) {
            // mengambil extension file
            $extension = $file->getClientOriginalExtension();
            // membuat nama file random berikut extension
            $filename     = str_random(40) . '.' . $extension;
            $image_resize = Image::make($file->getRealPath());
            $image_resize->save(public_path('image_bukti_bayar/' . $filename));

            return $filename;
        }
    }

    public function deleteFile($old_file, $path){
        if($old_file) {
            $filepath = public_path() . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR . $old_file;
            try {
              File::delete($filepath);
            } catch (FileNotFoundException $e){
               // File sudah tidak ada
            }
        }
    }

}
