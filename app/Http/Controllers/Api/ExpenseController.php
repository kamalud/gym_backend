<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Exception;
class ExpenseController extends Controller
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

        $expens = Expense::select('id','name','amount','type','date','create_by')->orderBy('id','DESC')
          ->paginate($limit);
          return $expens;
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
            'amount'=>"required",
            'type'=>"required",
            'date'=>"required",
        ]);
        if ($validator->fails()) return validator_error($validator->errors()) ;

        try{
            
           $expens = Expense::create([
            'name'=>$request->name,
            'amount'=>$request->amount,
            'type'=>$request->type,
            'date'=>$request->date,
            'create_by'   => Auth::user(),
          ]);

          return response_success([],__('message.expense.create.success'));
        }catch(Exception $e){
            return response_error([],__('message.expense.create.error'));
        }
        
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $expens = Expense::find($id);
        return $expens;
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
            'amount'=>"required",
            'type'=>"required",
            'date'=>"required",
        ]);
        if ($validator->fails()) return validator_error($validator->errors()) ;

        $expens = Expense::find($id);
        
        try{
        $expens->name = $request->name;
        $expens->amount = $request->amount;
        $expens->type = $request->type;
        $expens->date = $request->date;
        $expens->create_by =  Auth::user();
        $expens->update();
          return response_success([],__('message.expense.update.success'));
        }catch(Exception $e){
          return response_error([],__('message.expense.update.error'));
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
          $expense = Expense::find($id);
       
           $expense->delete();

           return response_success([],__('message.expense.manage.deleted'));
        
        }catch(Exception $e){
            return response_error([],__('message.expense.mange.not_found'));
        }
         
    }
}
