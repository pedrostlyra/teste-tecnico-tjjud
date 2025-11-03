<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class LivroAssuntoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('livro_assunto')->insert([
            ['Livro_Codl' => 1, 'Assunto_CodAs' => 1],
            ['Livro_Codl' => 2, 'Assunto_CodAs' => 2],
            ['Livro_Codl' => 3, 'Assunto_CodAs' => 2],
        ]);
    }
}
