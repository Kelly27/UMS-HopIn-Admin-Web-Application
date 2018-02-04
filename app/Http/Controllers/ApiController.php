<!-- A lesson for JWTAuth -->
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuthExceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class ApiController extends Controller
{
    public function register(Request $request){
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        User::create($input);
        return response()->json(['result'=>true]);
    }

    public function login(Request $request){
        $input = $request->all();
        if(!$token = JWTAuth::attempt($input)){ //HERE '=' IS ONE ONLY, NOT "=="
            return response()->json(['result' => 'Incorrect Staff Number or Password;']);
        }
        return response()->json(['result' => $token]);
    }

    public function get_user_details(Request $request){
        $input = $request->all();
        $user = JWTAuth::toUser($input['token']);
        return response()->json(['result' => $user]);
    }
}
