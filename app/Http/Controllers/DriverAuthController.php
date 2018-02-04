<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Driver;
// use Illuminate\Foundation\Auth\ThrottlesLogins;
// use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
// use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;

class DriverAuthController extends Controller
{
    // use AuthenticatesAndRegistersUsers, ThrottlesLogins;
    protected $guard = 'drivers';

    public function register(){
        return Driver::all();
    }

    public function login(Request $request){
        $credentials = $request->only('staff_number', 'password');
        // return $credentials;
        // dd(Auth::guard('drivers'));
        if ( $token = Auth::guard('drivers')->attempt($credentials) ) {
            return response()->json(['result' => $token]);
        } else {
            return response()->json(['result'=>false]);
        }
    }

}
