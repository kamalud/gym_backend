<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;
use Faker\Factory;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        Setting::create([
            'name'=>'Gyme Fit',
            'mobile'=>'01761001703',
            'email'=>'gym@gmail.com',
            'logo'=>$faker->imageUrl,
            'fav_icon'=>$faker->imageUrl,
            'create_by'=>rand(1,25),
          ]);
    }
}
