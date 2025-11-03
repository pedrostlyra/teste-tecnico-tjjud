<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class AutorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('autores')->insert([
            ['Nome' => 'Machado de Assis'],
            ['Nome' => 'Clarice Lispector'],
            ['Nome' => 'Jorge Amado'],
        ]);
    }
}
