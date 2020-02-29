<?php

use Illuminate\Database\Seeder;
use App\Models\Location;
class LocationSeeder extends Seeder
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
            Location::truncate();
            $locations = [
                [
                    'uuid'    => (String) Str::uuid(),
                    'city_id' => 1,
                    'name' => "Chandmari",
                    'status'  => 1,
                ],
                [
                    'uuid'    => (String) Str::uuid(),
                    'city_id' => 1,
                    'name' => "Ambari",
                    'status'  => 1,
                ],
                [
                    'uuid'    => (String) Str::uuid(),
                    'city_id' => 1,
                    'name'    => "Ganeshguri",
                    'status'  => 1,
                ],
                [
                    'uuid'    => (String) Str::uuid(),
                    'city_id' => 1,
                    'name'    => "Khanapara",
                    'status'  => 1,
                ],

            ];
            foreach ($locations as $location) {
                $data = [
                    'uuid'    => (String) Str::uuid(),
                    'city_id' => $location['city_id'],
                    'name' => $location['name'],
                    'status'  => $location['status'],
                ];
                Location::create($data);
            }

        } catch (Exception $e) {
            DB::rollback();
            dd($e);
        }
        DB::commit();
    }
}
