<?php

use Illuminate\Database\Seeder;
use App\Models\Product;
class ProductSeeder extends Seeder
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
            Product::truncate();
            $products = [
                [
                    'uuid'    => (String) Str::uuid(),
                    'sku'   =>"SKU001",
                    'category_id' => 1,
                    'name' => "Rice KRT",
                    'desc'  =>"",
                    'status'  => 1,
                ],
                [
                    'uuid'    => (String) Str::uuid(),
                    'sku'   =>"SKU001",
                    'category_id' => 1,
                    'name' => "Rice KRT",
                    'desc'  =>"",
                    'status'  => 1,
                ],
                [
                    'uuid'    => (String) Str::uuid(),
                    'sku'   =>"SKU002",
                    'category_id' => 1,
                    'name' => "Rice Joha (Local)",
                    'desc'  =>"",
                    'status'  => 1,
                ],
                [
                    'uuid'    => (String) Str::uuid(),
                    'sku'   =>"SKU003",
                    'category_id' => 1,
                    'name' => "Rice Joha (Rampal)",
                    'desc'  =>"",
                    'status'  => 1,
                ],
                [
                    'uuid'    => (String) Str::uuid(),
                    'sku'   =>"SKU004",
                    'category_id' => 1,
                    'name' => "Rice Parima",
                    'desc'  =>"",
                    'status'  => 1,
                ],
                [
                    'uuid'    => (String) Str::uuid(),
                    'sku'   =>"SKU005",
                    'category_id' => 1,
                    'name' => "Bot Dal",
                    'desc'  =>"",
                    'status'  => 1,
                ],
                [
                    'uuid'    => (String) Str::uuid(),
                    'sku'   =>"SKU006",
                    'category_id' => 1,
                    'name' => "Masur Dal (Big Grains)",
                    'desc'  =>"",
                    'status'  => 1,
                ],
                [
                    'uuid'    => (String) Str::uuid(),
                    'sku'   =>"SKU007",
                    'category_id' => 1,
                    'name' => "Masur Dal (Small Grains)",
                    'desc'  =>"",
                    'status'  => 1,
                ],
                [
                    'uuid'    => (String) Str::uuid(),
                    'sku'   =>"SKU008",
                    'category_id' => 1,
                    'name' => "Refine Vegetable Oil",
                    'desc'  =>"",
                    'status'  => 1,
                ],
                [
                    'uuid'    => (String) Str::uuid(),
                    'sku'   =>"SKU009",
                    'category_id' => 1,
                    'name' => "Refine Sunflower Oil",
                    'desc'  =>"",
                    'status'  => 1,
                ],
                [
                    'uuid'    => (String) Str::uuid(),
                    'sku'   =>"SKU0010",
                    'category_id' => 1,
                    'name' => "Mustard Oil",
                    'desc'  =>"",
                    'status'  => 1,
                ],
                [
                    'uuid'    => (String) Str::uuid(),
                    'sku'   =>"SKU0011",
                    'category_id' => 1,
                    'name' => "Cornflakes",
                    'desc'  =>"",
                    'status'  => 1,
                ],
                [
                    'uuid'    => (String) Str::uuid(),
                    'sku'   =>"SKU0012",
                    'category_id' => 2,
                    'name' => "Cabbage",
                    'desc'  =>"",
                    'status'  => 1,
                ],
                [
                    'uuid'    => (String) Str::uuid(),
                    'sku'   =>"SKU0013",
                    'category_id' => 2,
                    'name' => "Cauliflower",
                    'desc'  =>"",
                    'status'  => 1,
                ],
                [
                    'uuid'    => (String) Str::uuid(),
                    'sku'   =>"SKU0014",
                    'category_id' => 2,
                    'name' => "Tomato",
                    'desc'  =>"",
                    'status'  => 1,
                ],
                [
                    'uuid'    => (String) Str::uuid(),
                    'sku'   =>"SKU0015",
                    'category_id' => 2,
                    'name' => "Pinach",
                    'desc'  =>"",
                    'status'  => 1,
                ],
                [
                    'uuid'    => (String) Str::uuid(),
                    'sku'   =>"SKU0016",
                    'category_id' => 3,
                    'name' => "Apple",
                    'desc'  =>"",
                    'status'  => 1,
                ],
                [
                    'uuid'    => (String) Str::uuid(),
                    'sku'   =>"SKU0017",
                    'category_id' => 3,
                    'name' => "Orange",
                    'desc'  =>"",
                    'status'  => 1,
                ],
            ];
            foreach ($products as $product) {
                $data = [
                    'uuid'    => (String) Str::uuid(),
                    'sku' => $product['sku'],
                    'category_id' => $product['category_id'],
                    'name' => $product['name'],
                    'desc' => $product['desc'],
                    'status'  => $product['status'],
                ];
                Product::create($data);
            }

        } catch (Exception $e) {
            DB::rollback();
            dd($e);
        }
        DB::commit();
    }
}
