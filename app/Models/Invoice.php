<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = ['member_id','uuid','amount','fee_type','pament_type'
    ,'start_date','end_date','create_by',];

    public function users(){
        return $this->belongsTo(User::class,'create_by');
      }
   
      public function member(){
       return $this->belongsTo(Membar::class,'member_id','member_id');
     }

      protected $casts = [
        'created_at'=>'datetime:d M, Y',
        'end_date'=>'datetime:d M, Y',
        'start_date'=>'datetime:d M, Y',
      ];
     
}
