<?php

use Illuminate\Database\Seeder;
use App\Models\State;

class StateSeeder extends Seeder
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
            State::truncate();
            $states = [
                [
                    'uuid'   => (String) Str::uuid(),
                    'name'   => "Andhra Pradesh",
                    'status' => 1,
                ],
                [
                    'uuid'   => (String) Str::uuid(),
                    'name'   => "Andhra Pradesh",
                    'status' => 1,
                ],
                [
                    'uuid'   => (String) Str::uuid(),
                    'name'   => "Assam",
                    'status' => 1,
                ],
                [
                    'uuid'   => (String) Str::uuid(),
                    'name'   => "Bihar",
                    'status' => 1,
                ],
                [
                    'uuid'   => (String) Str::uuid(),
                    'name'   => "Chhattisgarh",
                    'status' => 1,
                ],
                [
                    'uuid'   => (String) Str::uuid(),
                    'name'   => "Goa",
                    'status' => 1,
                ],
                [
                    'uuid'   => (String) Str::uuid(),
                    'name'   => "Gujarat",
                    'status' => 1,
                ],
                [
                    'uuid'   => (String) Str::uuid(),
                    'name'   => "Haryana",
                    'status' => 1,
                ],
                [
                    'uuid'   => (String) Str::uuid(),
                    'name'   => "Himachal Pradesh",
                    'status' => 1,
                ],
                [
                    'uuid'   => (String) Str::uuid(),
                    'name'   => "Jammu and Kashmir",
                    'status' => 1,
                ],
                [
                    'uuid'   => (String) Str::uuid(),
                    'name'   => "Jharkhand",
                    'status' => 1,
                ],
                [
                    'uuid'   => (String) Str::uuid(),
                    'name'   => "Karnataka",
                    'status' => 1,
                ],
                [
                    'uuid'   => (String) Str::uuid(),
                    'name'   => "Kerala",
                    'status' => 1,
                ],
                [
                    'uuid'   => (String) Str::uuid(),
                    'name'   => "Madhya Pradesh",
                    'status' => 1,
                ],
                [
                    'uuid'   => (String) Str::uuid(),
                    'name'   => "Maharashtra",
                    'status' => 1,
                ],
                [
                    'uuid'   => (String) Str::uuid(),
                    'name'   => "Manipur",
                    'status' => 1,
                ],
                [
                    'uuid'   => (String) Str::uuid(),
                    'name'   => "Meghalaya",
                    'status' => 1,
                ],
                [
                    'uuid'   => (String) Str::uuid(),
                    'name'   => "Mizoram",
                    'status' => 1,
                ],
                [
                    'uuid'   => (String) Str::uuid(),
                    'name'   => "Nagaland",
                    'status' => 1,
                ],
                [
                    'uuid'   => (String) Str::uuid(),
                    'name'   => "Odisha",
                    'status' => 1,
                ],
                [
                    'uuid'   => (String) Str::uuid(),
                    'name'   => "Punjab",
                    'status' => 1,
                ],
                [
                    'uuid'   => (String) Str::uuid(),
                    'name'   => "Rajasthan",
                    'status' => 1,
                ],
                [
                    'uuid'   => (String) Str::uuid(),
                    'name'   => "Sikkim",
                    'status' => 1,
                ],
                [
                    'uuid'   => (String) Str::uuid(),
                    'name'   => "Tamil Nadu",
                    'status' => 1,
                ],
                [
                    'uuid'   => (String) Str::uuid(),
                    'name'   => "Telangana",
                    'status' => 1,
                ],
                [
                    'uuid'   => (String) Str::uuid(),
                    'name'   => "Tripura",
                    'status' => 1,
                ],
                [
                    'uuid'   => (String) Str::uuid(),
                    'name'   => "Uttar Pradesh",
                    'status' => 1,
                ],
                [
                    'uuid'   => (String) Str::uuid(),
                    'name'   => "Uttarakhand",
                    'status' => 1,
                ],
                [
                    'uuid'   => (String) Str::uuid(),
                    'name'   => "West Bengal",
                    'status' => 1,
                ],

            ];
            foreach ($states as $state) {
                $data = [
                    'uuid' => (String) Str::uuid(),
                    'name' => $state['name'],
                    'status' => $state['status'],
                ];
                State::create($data);
            }

        } catch (Exception $e) {
            DB::rollback();
            dd($e);
        }
        DB::commit();
    }
}
