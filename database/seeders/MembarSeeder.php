<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Models\Membar;
use Illuminate\Support\Str;

class MembarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          
        $faker = Factory::create();

        foreach(range(1,20) as $item){
            Membar::create([
              'name'=>$faker->name,
               'uuid'   => Str::uuid()->serialize(),
              'member_id'=>date('Y').str_pad($item,6,0,STR_PAD_LEFT),
              'gender'=>rand(0,1),
              'mobile'=>'01'.rand(3,9).rand(00000000,99999999),
            //   'blood_group'=>$faker->bloodGroup(),
              'address'=>$faker->address,
              'photo'=>$faker->imageUrl,
              'create_by'=>rand(1,25),
            ]);
        }
    }
}
