<?php

namespace Tests\Unit\Requests;

use Tests\TestCase;
use App\Http\Requests\LivroRequest;
use Illuminate\Support\Facades\Validator;

class LivroRequestTest extends TestCase
{
    public function test_validates_titulo_is_required(): void
    {
        $request = new LivroRequest();
        $rules = $request->rules();

        $validator = Validator::make([], $rules);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('titulo', $validator->errors()->toArray());
    }

    public function test_validates_titulo_max_length(): void
    {
        $request = new LivroRequest();
        $rules = $request->rules();

        $data = [
            'titulo' => str_repeat('a', 41), // Exceeds max 40
            'editora' => 'Test',
            'valor' => '50.00',
        ];

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('titulo', $validator->errors()->toArray());
    }

    public function test_validates_editora_is_required(): void
    {
        $request = new LivroRequest();
        $rules = $request->rules();

        $validator = Validator::make(['titulo' => 'Test'], $rules);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('editora', $validator->errors()->toArray());
    }

    public function test_validates_valor_is_required(): void
    {
        $request = new LivroRequest();
        $rules = $request->rules();

        $validator = Validator::make(['titulo' => 'Test', 'editora' => 'Test'], $rules);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('valor', $validator->errors()->toArray());
    }

    public function test_validates_valor_is_numeric(): void
    {
        $request = new LivroRequest();
        $rules = $request->rules();

        $data = [
            'titulo' => 'Test',
            'editora' => 'Test',
            'valor' => 'not-a-number',
        ];

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('valor', $validator->errors()->toArray());
    }

    public function test_validates_autores_array(): void
    {
        $request = new LivroRequest();
        $rules = $request->rules();

        $data = [
            'titulo' => 'Test',
            'editora' => 'Test',
            'valor' => '50.00',
            'autores' => 'not-an-array',
        ];

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('autores', $validator->errors()->toArray());
    }

    public function test_validates_edicao_is_required(): void
    {
        $request = new LivroRequest();
        $rules = $request->rules();

        $data = [
            'titulo' => 'Test',
            'editora' => 'Test',
            'valor' => '50.00',
        ];

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('edicao', $validator->errors()->toArray());
    }

    public function test_validates_edicao_is_integer(): void
    {
        $request = new LivroRequest();
        $rules = $request->rules();

        $data = [
            'titulo' => 'Test',
            'editora' => 'Test',
            'edicao' => 'not-a-number',
            'ano_publicacao' => '2024',
            'valor' => '50.00',
        ];

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('edicao', $validator->errors()->toArray());
    }
}

