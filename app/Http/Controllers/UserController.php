<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function login(Request $request) {
        /**
         *  {
         *      email: saul@hotmail.com
         *      password: 123456 
         *  }
         */
        $user = User::whereEmail($request->email)->first(); // get es para
                                                            // traer todo
        if (!is_null($user) && Hash::check($request->password, $user->password)) {
            
            $user->api_token = Str::random(150);
            $user->save();

            return response()->json(['res' => true, 
                                  'token' => $user->api_token,
                                  'user' => $user,
                                  'message' => 'Bienvenido al sistema',
                                  ], 200);
        } else {
            return response()->json(['res' => false, 
                                  'message' => 'Cuenta o password incorrectos',
                                  ], 200);
        }
    }

    public function logout() {

        $user = auth()->user();
        $user->api_token = null;
        $user->save();

        return \response()->json(['res' => true, 'message'=>'Adios'], 200);
    }
}
