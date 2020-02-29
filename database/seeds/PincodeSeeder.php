<?php

use App\Models\Pincode;
use Illuminate\Database\Seeder;

class PincodeSeeder extends Seeder
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
            Pincode::truncate();
            $pincodes = [
                [
                    'uuid'    => (String) Str::uuid(),
                    'city_id' => 1,
                    'pincode' => 781003,
                    'status'  => 1,
                ],
                [
                    'uuid'    => (String) Str::uuid(),
                    'city_id' => 1,
                    'pincode' => 781004,
                    'status'  => 1,
                ],
                [
                    'uuid'    => (String) Str::uuid(),
                    'city_id' => 1,
                    'pincode'    => 781005,
                    'status'  => 1,
                ],

            ];
            foreach ($pincodes as $pincode) {
                $data = [
                    'uuid'    => (String) Str::uuid(),
                    'city_id' => $pincode['city_id'],
                    'pincode' => $pincode['pincode'],
                    'status'  => $pincode['status'],
                ];
                Pincode::create($data);
            }

        } catch (Exception $e) {
            DB::rollback();
            dd($e);
        }
        DB::commit();
    }
}
