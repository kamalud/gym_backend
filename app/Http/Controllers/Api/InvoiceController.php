<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Exception;
class InvoiceController extends Controller
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
        
        $invoice = Invoice::with('users','member')->orderBy('id','DESC')
          ->paginate($limit);
        return $invoice;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
     * 
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'member_id'=>"required",
            'amount'=>"required",
            'fee_type'=>"required",
            'pament_type'=>"required",
            'start_date'=>"required|date_format:Y-m-d",
            'end_date'=>"required|date_format:Y-m-d",
        ]);
        if ($validator->fails()) return validator_error($validator->errors()) ;

        try{
            $invoice = Invoice::create([
              'uuid'   => Str::uuid()->serialize(),
              'member_id'=>$request->member_id,
              'amount'=>$request->amount,
              'fee_type'=>$request->fee_type,
              'pament_type'=>$request->pament_type,
              'start_date'=>$request->start_date,
              'end_date'=>$request->end_date,
              // 'create_by'   => Auth::user()->id,
            ]);
          return response_success([],__('message.invoice.create.success'));
        } catch(Exception $e){
          return response_error([],__('message.invoice.create.error'));
        };
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {        
        $invoice = Invoice::with('users','member')->where('uuid',$uuid)->first();
        return $invoice;
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
            'amount'=>"required",
            'fee_type'=>"required",
            'pament_type'=>"required",
            'start_date'=>"required|date_format:Y-m-d",
            'end_date'=>"required|date_format:Y-m-d",
        ]);
        if ($validator->fails()) return validator_error($validator->errors()) ;
        $invoice = Invoice::find($id);
        
        try{

        $invoice->amount = $request->amount;
        $invoice->fee_type = $request->fee_type;
        $invoice->start_date = $request->start_date;
        $invoice->end_date = $request->end_date;
        $invoice->create_by = Auth::user()->id;
        $invoice->update();
          return response_success([],__('message.invoice.update.success'));
        } catch(Exception $e){
          return response_error([],__('message.invoice.update.error'));
        };
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
          $invoice = Invoice::where('uuid',$uuid)->first();
          $invoice->delete();
         return response_success($invoice,__('message.invoice.delete.success'));
        } catch(Exception $e){
          return response_error($invoice,__('message.invoice.delete.not_found'));
        };
    }
}
