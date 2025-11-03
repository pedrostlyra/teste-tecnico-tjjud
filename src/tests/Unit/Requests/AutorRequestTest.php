<?php

namespace Tests\Unit\Requests;

use Tests\TestCase;
use App\Http\Requests\AutorRequest;
use Illuminate\Support\Facades\Validator;

class AutorRequestTest extends TestCase
{
    public function test_validates_nome_is_required(): void
    {
        $request = new AutorRequest();
        $rules = $request->rules();

        $validator = Validator::make([], $rules);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('nome', $validator->errors()->toArray());
    }

    public function test_validates_nome_max_length(): void
    {
        $request = new AutorRequest();
        $rules = $request->rules();

        $data = [
            'nome' => str_repeat('a', 41), // Exceeds max 40
        ];

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('nome', $validator->errors()->toArray());
    }

    public function test_validates_nome_is_string(): void
    {
        $request = new AutorRequest();
        $rules = $request->rules();

        $data = [
            'nome' => 12345,
        ];

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('nome', $validator->errors()->toArray());
    }

    public function test_authorize_returns_true(): void
    {
        $request = new AutorRequest();

        $this->assertTrue($request->authorize());
    }
}

