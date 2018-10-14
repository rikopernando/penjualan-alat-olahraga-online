<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Produk;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\File;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $produks = Produk::select('id','nama','harga_jual','deskripsi')->where(function($query) use ($request){
					$query->orwhere('nama', 'LIKE', '%' . $request->search . '%')
					->orwhere('harga_jual', 'LIKE', '%' . $request->search . '%')
					->orwhere('deskripsi', 'LIKE', '%' . $request->search . '%');
                })->orderBy('id','desc')->paginate(10);
        $data = [];

        foreach($produks as $produk){
            $data[] = [
                    'id' => $produk->id,
                    'nama' => $produk->nama,
                    'harga_jual' => number_format($produk->harga_jual,0,',','.'),
                    'deskripsi' => $produk->deskripsi,
                ];
        }

        return app(PaginateController::class)->getPagination($produks, $data, '/api/produks');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'nama' => 'required|string',
            'harga_jual' => 'required|numeric|digits_between:1,11',
            'deskripsi' => 'required|string',
            'foto' => 'image|max:3072'
        ]);  

        $produk = Produk::create([
            'nama' => $request->nama,
            'harga_jual' => $request->harga_jual,
            'deskripsi' => $request->deskripsi
        ]);

        if($request->hasFile('foto')){
            $foto = $request->file('foto');
            $produk->foto = $this->uploadFile($foto);
            $produk->save();
        }

        return response()->json([
            'message' => 'Success Create Produk',
            'data' => $produk
        ],200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $produk = Produk::select('id','nama','harga_jual','deskripsi','foto')->whereId($id)->first();
      
       $produk->foto ? $foto = url('image_produks/'.$produk->foto) : $foto = $produk->foto;

       return response()->json([
            'id' => $produk->id,
            'nama' => $produk->nama,
            'harga_jual' => $produk->harga_jual,
            'deskripsi' => $produk->deskripsi,
            'foto' => $produk->foto,
            'previewFoto' => $foto
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
        $this->validate($request,[
            'nama' => 'required|string',
            'harga_jual' => 'required|numeric|digits_between:1,11',
            'deskripsi' => 'required|string|min:6',
            'foto' => 'image|max:3072'
        ]);  

        $produk = Produk::find($id);	

        $produk->update([
            'nama' => $request->nama,
            'harga_jual' => $request->harga_jual,
            'deskripsi' => $request->deskripsi
        ]);

        if($request->hasFile('foto')){
            $foto = $request->file('foto');
            $this->deleteFile($produk->foto,'image_produks');
            $produk->foto = $this->uploadFile($foto);
            $produk->save();
        }

        return response()->json([
            'message' => 'Success Update Produk',
            'data' => $produk
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
        $produk = Produk::find($id);
        $this->deleteFile($produk->foto,'image_produks');
        $produk->destroy($id);
        return response(200);
    }

    public function uploadFile($file) {
        if (is_array($file) || is_object($file)) {
            // mengambil extension file
            $extension = $file->getClientOriginalExtension();
            // membuat nama file random berikut extension
            $filename     = str_random(40) . '.' . $extension;
            $image_resize = Image::make($file->getRealPath());
            $image_resize->fit(236,255);
            $image_resize->save(public_path('image_produks/' . $filename));

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
