<?php

use Illuminate\Database\Seeder;
use App\Models\Shop;
class ShopSeeder extends Seeder
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
            Shop::truncate();
            $shops = [
                [
                    'uuid'    => (String) Str::uuid(),
                    'location_id' => 1,
                    'name' => "Kalyan Stores",
                    'address' => "191,MRD Road, Chandmari, Guwahati",
                    'mobile1' => "9898989898",
                    'mobile2' => "8989898989",
                    'email' => "kstores@gmail.com",
                    'website' => "www.kstores.com",
                    'pincode' => "781003",
                    'lat' => "19.1",
                    'long' => "18.2",
                    'status'  => 1,
                ],
                [
                    'uuid'    => (String) Str::uuid(),
                    'location_id' => 2,
                    'name' => "Pick Me Stores",
                    'address' => "Ambari",
                    'mobile1' => "9898009898",
                    'mobile2' => "8989008989",
                    'email' => "PStores@gmail.com",
                    'website' => "www.pickstores.com",
                    'pincode' => "781004",
                    'lat' => "19.1",
                    'long' => "18.2",
                    'status'  => 1,
                ],


            ];
            foreach ($shops as $shop) {
                $data = [
                    'uuid'    => (String) Str::uuid(),
                    'location_id' => $shop['location_id'],
                    'name' => $shop['name'],
                    'address' => $shop['address'],
                    'mobile1' => $shop['mobile1'],
                    'mobile2' => $shop['mobile2'],
                    'email' => $shop['email'],
                    'website' => $shop['website'],
                    'pincode' => $shop['pincode'],
                    'lat' => $shop['lat'],
                    'long' => $shop['long'],

                    'status'  => $shop['status'],
                ];
                Shop::create($data);
            }

        } catch (Exception $e) {
            DB::rollback();
            dd($e);
        }
        DB::commit();
    }
}
