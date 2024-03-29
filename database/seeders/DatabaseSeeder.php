<?php

namespace Database\Seeders;

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
        // \App\Models\User::factory(10)->create();
        \App\Models\Client::factory(50)->create();
        \App\Models\Company::factory(50)->create();
        \App\Models\Vendor::factory(50)->create();
        \App\Models\Item::factory(50)->create();
        \App\Models\Invoice::factory(50)->create();
    }
}
