<?php

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\City;

class CategoryCitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::beginTransaction();
        try {
            foreach(range(0,10) as $number){
                $data = [
                    'category_id' => App\Models\Category::inRandomOrder()->first()->id,
                    'city_id'  => App\Models\City::inRandomOrder()->first()->id,
                ];
                if (!DB::table('category_city')->where($data)->exists()) {
                    DB::table('category_city')->insert($data);
                }
            }

        } catch (Exception $e) {
            DB::rollback();
            dd($e);
        }
        DB::commit();

    }
}
