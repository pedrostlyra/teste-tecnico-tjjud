<?php

namespace Tests\Unit\Requests;

use Tests\TestCase;
use App\Http\Requests\AssuntoRequest;
use Illuminate\Support\Facades\Validator;

class AssuntoRequestTest extends TestCase
{
    public function test_validates_descricao_is_required(): void
    {
        $request = new AssuntoRequest();
        $rules = $request->rules();

        $validator = Validator::make([], $rules);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('descricao', $validator->errors()->toArray());
    }

    public function test_validates_descricao_max_length(): void
    {
        $request = new AssuntoRequest();
        $rules = $request->rules();

        $data = [
            'descricao' => str_repeat('a', 21), // Exceeds max 20
        ];

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('descricao', $validator->errors()->toArray());
    }

    public function test_validates_livros_array(): void
    {
        $request = new AssuntoRequest();
        $rules = $request->rules();

        $data = [
            'descricao' => 'Test',
            'livros' => 'not-an-array',
        ];

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('livros', $validator->errors()->toArray());
    }

    public function test_authorize_returns_true(): void
    {
        $request = new AssuntoRequest();

        $this->assertTrue($request->authorize());
    }
}

