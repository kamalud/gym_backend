<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Membar;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Exception;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = 10;
        if(isset($request->limit)) $limit = $request->limit;
        
         $member  = Membar::with('users','invoice')->select(['id','uuid','member_id','name','gender','mobile','blood_group','photo','address','start_date','end_date','card_no','status','lock','create_by',])
            ->orderBy('id','DESC')
            ->paginate($limit);
            return $member;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>"required|max:50",
            'mobile'=>"required|max:11|min:11|unique:membars",
            'address'=>"required",
            'blood_group'=>"required",
            'gender'=>"required",
            'photo'=>"required",
        ]);

        if ($validator->fails()) return validator_error($validator->errors()) ;


        // try{
        $photo =imageUpload($request->photo,'members');
        $member = Membar::create([
            'uuid'   => Str::uuid()->serialize(),
            'member_id'   => uniqid(),
            'name'        => $request->name,
            'gender'      => $request->gender,
            'mobile'      => $request->mobile,
            'blood_group' => $request->blood_group,
            'address'     => $request->address,
            'photo'       => $photo['path'],
            'create_by'   => Auth::user(),
          ]);
          $member->member_id = date('Y').str_pad($member->id,6,0,STR_PAD_LEFT);
          $member->save();

           return response_success([],__('message.member.create.success'));
        // }catch(Exception $e){
        //     return response_error(__('message.member.create.error'));
        // }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        $member = Membar::with('users')->where('uuid',$uuid)->first();
        return $member;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'=>"required|max:50",
            'mobile'=>"required|max:11|min:11|unique:membars,id,* .$id",
            'address'=>"required",
            'blood_group'=>"required",
            'gender'=>"required",
        ]);

        if ($validator->fails()) return validator_error($validator->errors()) ;
    

            
        try{
            $member = Membar::find($id);
            $member->name = $request->name;
            $member->mobile  = $request->mobile ;
            $member->address = $request->address;
            $member->blood_group = $request->blood_group;
            $member->gender = $request->gender;
            $member->create_by = Auth::user()->id;

            if(strlen($request->photo) > 100){
                $photo =imageUpload($request->photo,'members');
                $member->photo = $photo['path'];
            }

            $member->save();
             return response_success([],__('message.member.update.success'));
        }catch(Exception $e){
            return response_error(__('message.member.update.error'));
        }
           
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id0
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
          $member = Membar::where('uuid',$uuid)->first();
       
           $member->delete();

           return response_success([],__('message.member.manage.deleted'));
        
        }catch(Exception $e){
            return response_error(__('message.member.manage.not_found'));
        }
    }


}
