<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use DB;

class AuthController extends Controller
{
    public function getUserById($id){ 
        $user = User::find($id); //return obj
        return response()->json([
            'user'=> $user
        ]);
    }
}
