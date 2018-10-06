<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;

class AuthController extends Controller
{
    public function auth() {
        if(Auth::check()){
            return User::with('role')->where('id',Auth::User()->id)->first();
        }else{
            return Auth::User();
        }
    }
}

