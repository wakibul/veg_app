<?php

use Illuminate\Database\Seeder;
use App\Models\Category;
class CategorySeeder extends Seeder
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
            Category::truncate();
            $categories = [
                [
                    'uuid'    => (String) Str::uuid(),

                    'name' => "Grocery",
                    'status'  => 1,
                ],
                [
                    'uuid'    => (String) Str::uuid(),

                    'name' => "Vegetable",
                    'status'  => 1,
                ],
                [
                    'uuid'    => (String) Str::uuid(),

                    'name'    => "Fruits",
                    'status'  => 1,
                ],

            ];
            foreach ($categories as $category) {
                $data = [
                    'uuid'    => (String) Str::uuid(),

                    'name' => $category['name'],
                    'status'  => $category['status'],
                ];
                Category::create($data);
            }

        } catch (Exception $e) {
            DB::rollback();
            dd($e);
        }
        DB::commit();
    }
}
