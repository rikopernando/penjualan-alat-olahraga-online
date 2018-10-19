<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Indonesia;

class LokasiController extends Controller
{
    public function provinsi(){
        $provinsi = Indonesia::allProvinces();
        return response()->json($provinsi);
    }

    public function pilih_wilayah($id,$type){

   # Tarik ID_wilayah & tipe_wilayah
        $id_wilayah   = $id;
        $type_wilayah = $type;

        # Buat pilihan "Switch Case" berdasarkan variabel "type" dari dari data yg dikirim
        switch ($type_wilayah):
    # untuk kasus "kabupaten"
        case 'kabupaten':
        $kabupaten = Indonesia::allCities()->where('province_id', $id);
        return response()->json($kabupaten);
        break;
    # untuk kasus "kecamatan"
        case 'kecamatan':
        $kecamatan = Indonesia::allDistricts()->where('city_id', $id);
        return response()->json($kecamatan);
        break;
    # untuk kasus "kelurahan"
        case 'kelurahan':
        $kelurahan = Indonesia::allVillages()->where('district_id', $id);
        return response()->json($kelurahan);
        break;
        # pilihan berakhir
        endswitch;
    }
}
