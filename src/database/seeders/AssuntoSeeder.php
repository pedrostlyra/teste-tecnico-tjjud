<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class AssuntoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('assuntos')->insert([
            ['Descricao' => 'Ficção'],
            ['Descricao' => 'Romance'],
            ['Descricao' => 'História'],
        ]);
    }
}
