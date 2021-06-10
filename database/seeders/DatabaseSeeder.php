<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rubro;
use App\Models\Articulo;
use App\Models\ComprobanteCabeza;
use App\Models\ComprobanteRenglon;

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
        \App\Models\Rubro::factory(24)->create();
        \App\Models\Articulo::factory(40)->create();
        \App\Models\ComprobanteCabeza::factory(10)->create();
        \App\Models\ComprobanteRenglon::factory(40)->create();
    }
}
