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
         \App\Models\User::factory(10)
                        ->hasProductos(rand(1, 5))     // desde 1 a 5   
                        ->create();                     // registros para
    }                                                   // cada usuario
}