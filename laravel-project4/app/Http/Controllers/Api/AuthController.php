<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use DB;

class AuthController extends Controller
{
    public function storeLogin(Request $r){
        $email =$r->email;
        $password =$r->password;
        $user = User::where('email','=',$email)->where('password','=',md5($password))->first();
        if($user) {
            if($user->role=='admin') {
                return response()->json([
                    'user'=> $user,
                    'msg'=> 'Successfully Logged in'
                ]);
            }
            else if($user->role=='teacher') {
                return response()->json([
                    'user'=> $user,
                    'msg'=> 'Successfully Logged in'
                ]);
            }
            else if($user->role=='student') {
                return response()->json([
                    'user'=> $user,
                    'msg'=> 'Successfully Logged in'
                ]);
            }
        }
        else {
            // echo 'login failed <br>';
            return response()->json([
                'msg'=> 'Invalid Email or Password'
            ]);
        }
    }
    // public function getUserById($id){ 
    //     $user = User::find($id); //return obj
    //     return response()->json([
    //         'user'=> $user
    //     ]);
    // }
}
