<?php

use App\Models\Location;
use App\Models\Pincode;
use Illuminate\Database\Seeder;

class Location_PincodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::beginTransaction();
        try {
            foreach(range(0,10) as $number){
                $data = [
                    'location_id' => App\Models\Location::inRandomOrder()->first()->id,
                    'pincode_id'  => App\Models\Pincode::inRandomOrder()->first()->id,
                ];
                if (!DB::table('location_pincode')->where($data)->exists()) {
                    DB::table('location_pincode')->insert($data);
                }
            }

        } catch (Exception $e) {
            DB::rollback();
            dd($e);
        }
        DB::commit();

    }
}
