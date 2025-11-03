<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LivroRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titulo' => 'required|string|max:40',
            'editora' => 'required|string|max:40',
            'edicao' => 'required|integer|min:1',
            'ano_publicacao' => 'required|digits:4',
            'valor' => 'required|numeric|min:0',
            'autores' => 'nullable|array',
            'autores.*' => 'integer|exists:autores,CodAu',
            'assuntos' => 'nullable|array',
            'assuntos.*' => 'integer|exists:assuntos,CodAs',
        ];
    }

    public function messages(): array
    {
        return [
            'titulo.required' => 'O campo título é obrigatório.',
            'titulo.max' => 'O título pode ter no máximo 40 caracteres.',
            'editora.required' => 'O campo editora é obrigatório.',
            'valor.required' => 'O campo valor é obrigatório.',
            'valor.numeric' => 'O valor deve ser numérico.',
            'autores.*.exists' => 'Autor não encontrado.',
            'assuntos.*.exists' => 'Assunto não encontrado.',
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->has('valor')) {
            $valor = str_replace(['R$', '.', ' '], ['', '', ''], $this->input('valor'));
            $valor = str_replace(',', '.', $valor);
            $this->merge(['valor' => $valor]);
        }
    }
}

