<?php

namespace Database\Factories;

use App\Models\Livro;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Livro>
 */
class LivroFactory extends Factory
{
    protected $model = Livro::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'Titulo' => fake()->sentence(3),
            'Editora' => fake()->company(),
            'Edicao' => fake()->numberBetween(1, 10),
            'AnoPublicacao' => (string) fake()->year(),
            'Valor' => fake()->randomFloat(2, 10, 200),
        ];
    }
}
