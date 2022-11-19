<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membar extends Model
{
    use HasFactory;
    protected $fillable = ['member_id','uuid','name','gender','mobile','blood_group',
    'photo','address','start_date','end_date','card_no','status','lock','create_by',];


   public function users(){
     return $this->belongsTo(User::class,'create_by')->select('id','name');
   }

   public function invoice(){
    return $this->hasMany(Invoice::class,'member_id','member_id');
  }
}
