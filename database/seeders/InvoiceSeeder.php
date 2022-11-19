<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Models\Invoice;
use Illuminate\Support\Str;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        foreach(range(1,20) as $item){
            Invoice::create([
                'uuid'   => Str::uuid()->serialize(),   
              'member_id'=>date('Y').str_pad($item,6,0,STR_PAD_LEFT),
              'fee_type'=>'1',
              'pament_type'=>'1',
              'start_date'=>date('y-m-d'),
              'end_date'=>date('y-m-d',strtotime('+3 month')),
              'amount'=>rand(500,1000),
              'create_by'=>rand(1,25),
            ]);
    }
   }
}
