<?php

namespace Database\Factories;

use App\Models\Assunto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Assunto>
 */
class AssuntoFactory extends Factory
{
    protected $model = Assunto::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $assuntos = ['Ficção', 'Romance', 'Drama', 'Comédia', 'Aventura', 'Terror', 'Biografia', 'História'];
        
        return [
            'Descricao' => fake()->randomElement($assuntos),
        ];
    }
}
