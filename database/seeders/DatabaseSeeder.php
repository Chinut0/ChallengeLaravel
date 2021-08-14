<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        User::truncate();
        Product::truncate();

        $cantidadUsuarios = 5;
        $cantidadProducts = 20;

        // User::factory($cantidadUsuarios)->create();
        Product::factory($cantidadProducts)->create();
    }
}
