<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssuntoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'descricao' => 'required|string|max:20',
            'livros' => 'nullable|array',
            'livros.*' => 'integer|exists:livros,Codl',
        ];
    }

    public function messages(): array
    {
        return [
            'descricao.required' => 'O campo descrição é obrigatório.',
            'descricao.max' => 'A descrição pode ter no máximo 20 caracteres.',
            'livros.*.exists' => 'Livro não encontrado.',
        ];
    }
}

