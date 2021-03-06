<?php

use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {   $this->call(StatusTableSeeder::class);
        $this->call(Users_Table_Seeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(Brands_Table_Seeder::class);
        // $this->call(InstallmentTableSeeder::class);
        // $this->call(PaymentMethodsTableSeeder::class);
        $this->call(Products_Table_Seeder::class);
    }
}
