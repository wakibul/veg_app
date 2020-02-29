<?php

use Illuminate\Database\Seeder;
use App\Models\City;

class CitySeeder extends Seeder
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
            City::truncate();
            $cities = [
                [
                    'uuid'   => (String) Str::uuid(),
                    'state_id'   => 3,
                    'name'       => "Guwahati",
                    'status' => 1,
                ],
                [
                    'uuid'   => (String) Str::uuid(),
                    'state_id'   => 3,
                    'name'       => "Jorhat",
                    'status' => 1,
                ],
                [
                    'uuid'   => (String) Str::uuid(),
                    'state_id'   => 3,
                    'name'       => "Dibrugarh",
                    'status' => 1,
                ],


            ];
            foreach ($cities as $city) {
                $data = [
                    'uuid' => (String) Str::uuid(),
                    'state_id' => $city['state_id'],
                    'name' => $city['name'],
                    'status' => $city['status'],
                ];
                City::create($data);
            }

        } catch (Exception $e) {
            DB::rollback();
            dd($e);
        }
        DB::commit();
    }
}
