<?php

use App\Models\City;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(StateSeeder::class);
        $this->call(CitySeeder::class);
        $this->call(UnitSeeder::class);
        $this->call(PincodeSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(CategoryCitySeeder::class);
        $this->call(LocationSeeder::class);
        $this->call(PackSeeder::class);
        $this->call(ShopSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(Location_PincodeSeeder::class);
    }
}
