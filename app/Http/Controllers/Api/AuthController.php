<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
 use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;
class AuthController extends Controller
{
    public function login(Request $request){
        $creadintails = $request->only('email','password');

        $validator = Validator::make($creadintails, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) return validator_error($validator->errors()) ;

         if(Auth::attempt($creadintails)){
            $user = User::find(1);
            $data['name'] = $user->name;
            $data['email'] = $user->email;
            $data['token'] = $user->createToken('MyToken')->accessToken;
    
          return response_success($data,__('message.user.manage.login'));
         }else{
            return response_error(__('message.user.manage.not_found'));
         }
   


    }


public function logout(Request $request) {
    if ($request->user()) { 
        $request->user()->tokens()->delete();
    }

    return response()->json(['message' => 'Yes ! Users logout has been  successfuly'], 200);
}



}
