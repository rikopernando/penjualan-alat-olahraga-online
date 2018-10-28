<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\User;
use Auth;

class ProfilController extends Controller
{
    //
    public function ubahPassword(Request $request)
    {
        $this->validate($request,[
            'password_lama' => 'required|string|min:6',
            'password' => 'required|string|min:6|confirmed',
        ]);  

        $user = User::find(Auth::User()->id);
        $user->update(['password' => Hash::make($request->password)]);
        return response()->json([
            'message' => 'Berhasil Ubah Password' 
        ],200);
    }
}
