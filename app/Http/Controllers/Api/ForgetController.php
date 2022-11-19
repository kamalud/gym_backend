<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use app\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PasswordNotification;
use App\Notifications\ForgotPassword;

class ForgetController extends Controller
{
   public function forget(Request $request){

       // $creadintails = $request->only('email','password');

       //  $validator = Validator::make($creadintails, [
       //      'email' => 'required|email',
       //  ]);

       //  if ($validator->fails()) return validator_error($validator->errors()) ;
        
        
        $email = $request->email;
        $token = Str::random(65);

         DB::table('password_resets')->insert([
            'email'=>$email,
            'token'=>$token,
            'created_at' => now()->addHours(1)
         ]);

          $user = User::WhereEmail($email)->first();

         Notifications::send($user,new PasswordNotification($token)) ;

         return response_success('Password forget email send please check your email');
    }
}
