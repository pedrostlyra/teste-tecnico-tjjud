<?php

namespace App\Http\Controllers;

use App\Models\Assunto;
use App\Http\Requests\AssuntoRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AssuntoController extends Controller
{
    public function index()
    {
        $assuntos = Assunto::orderBy('Descricao')->paginate(10);
        return view('assuntos.index', compact('assuntos'));
    }

    public function create()
    {
        return view('assuntos.create');
    }

    public function store(AssuntoRequest $request): RedirectResponse
    {
        $data = [
            'Descricao' => $request->input('descricao'),
        ];

        $assunto = Assunto::create($data);

        return redirect()->route('assuntos.index')->with('success', 'Assunto criado com sucesso.');
    }

    public function edit(Assunto $assunto)
    {
        return view('assuntos.edit', compact('assunto'));
    }

    public function update(AssuntoRequest $request, Assunto $assunto): RedirectResponse
    {
        $data = [
            'Descricao' => $request->input('descricao'),
        ];

        $assunto->update($data);

        return redirect()->route('assuntos.index')->with('success', 'Assunto atualizado com sucesso.');
    }

    public function destroy(Assunto $assunto): RedirectResponse
    {
        $assunto->livros()->detach();
        $assunto->delete();
        return redirect()->route('assuntos.index')->with('success', 'Assunto excluído com sucesso.');
    }
}


