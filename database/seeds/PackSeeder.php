<?php

use Illuminate\Database\Seeder;
use App\Models\Pack;
class PackSeeder extends Seeder
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
            Pack::truncate();
            $packs = [
                [
                    'uuid'    => (String) Str::uuid(),
                    'unit_id' => 1,
                    'name' => "1 Kgs",
                    'status'  => 1,
                ],
                [
                    'uuid'    => (String) Str::uuid(),
                    'unit_id' => 2,
                    'name' => "500 Gms",
                    'status'  => 1,
                ],
                [
                    'uuid'    => (String) Str::uuid(),
                    'unit_id' => 2,
                    'name'    => "250 Gms",
                    'status'  => 1,
                ],
                [
                    'uuid'    => (String) Str::uuid(),
                    'unit_id' => 2,
                    'name'    => "50 Gms",
                    'status'  => 1,
                ],
                [
                    'uuid'    => (String) Str::uuid(),
                    'unit_id' => 3,
                    'name'    => "1 Lts",
                    'status'  => 1,
                ],
                [
                    'uuid'    => (String) Str::uuid(),
                    'unit_id' => 4,
                    'name'    => "1 Nos",
                    'status'  => 1,
                ],
                [
                    'uuid'    => (String) Str::uuid(),
                    'unit_id' => 4,
                    'name'    => "6 Nos",
                    'status'  => 1,
                ],
            ];
            foreach ($packs as $pack) {
                $data = [
                    'uuid'    => (String) Str::uuid(),
                    'unit_id' => $pack['unit_id'],
                    'name' => $pack['name'],
                    'status'  => $pack['status'],
                ];
                Pack::create($data);
            }

        } catch (Exception $e) {
            DB::rollback();
            dd($e);
        }
        DB::commit();
    }
}
