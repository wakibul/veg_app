<?php

use Illuminate\Database\Seeder;
use App\Models\Unit;
class UnitSeeder extends Seeder
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
            Unit::truncate();
            $units = [
                [
                    'uuid'    => (String) Str::uuid(),

                    'name' => "Kilogram",
                    'abb' => "Kgs",
                    'status'  => 1,
                ],
                [
                    'uuid'    => (String) Str::uuid(),

                    'name' => "Grams",
                    'abb' => "Gms",
                    'status'  => 1,
                ],
                [
                    'uuid'    => (String) Str::uuid(),

                    'name' => "Litres",
                    'abb' => "Lts",
                    'status'  => 1,
                ],
                [
                    'uuid'    => (String) Str::uuid(),

                    'name' => "Numbers",
                    'abb' => "Nos",
                    'status'  => 1,
                ],
                [
                    'uuid'    => (String) Str::uuid(),

                    'name' => "Meters",
                    'abb' => "Mtr",
                    'status'  => 1,
                ],

            ];
            foreach ($units as $unit) {
                $data = [
                    'uuid'    => (String) Str::uuid(),

                    'name' => $unit['name'],
                    'abb'   =>$unit['abb'],
                    'status'  => $unit['status'],
                ];
                Unit::create($data);
            }

        } catch (Exception $e) {
            DB::rollback();
            dd($e);
        }
        DB::commit();
    }
}
