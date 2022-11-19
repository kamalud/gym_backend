<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        User::create([
          'name'=>"kamal uddin",
          "email"=>"admin@gmail.com",
          "password"=>Hash::make('11111111'),
        ]);


        $faker = Factory::create();

        foreach(range(1,25) as $item){
            User::create([
              'name'=>$faker->name,
              "email"=>$faker->unique()->email,
              "password"=>Hash::make('11111111'),
            ]);
        }

        
    }
}
