<?php


function validator_error($errors){
   return response()->json([
    "success"=>false,
    "errors"=>$errors
   ],422);
}

function response_success($data,$message = '',$code = 200){
   
   $res =[
     "success"=>true,
     "data"=>$data,
    ];
    if($message !== '') $res['message']=$message;

    return response()->json($res,$code);
 }

 function response_error($message = '',$code = 400){

    $res =[
     "success"=>false,
    ];

    if($message !== '') $res['message']=$message;

    return response()->json($res,$code);
 }

  function imageUpload($image,$dir){
   $file = explode(';base64,',$image);
   $file1 = explode('/',$file[0]);
   $file_exe = end($file1);
   $file_name = uniqid().date('-Ymd-his.').$file_exe;
   $image_data = str_replace(',','', $file[1]);

   Storage::disk('public')->put($dir.'/'. $file_name, base64_decode($image_data));

   return [
     'name' => $file_name,
     'path' => Storage::disk('public')->url($dir.'/'.$file_name)
   ];
 }