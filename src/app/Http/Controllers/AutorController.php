<?php

namespace App\Http\Controllers;

use App\Models\Autor;
use App\Http\Requests\AutorRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AutorController extends Controller
{
    public function index()
    {
        $autores = Autor::orderBy('Nome')->paginate(10);
        return view('autores.index', compact('autores'));
    }

    public function create()
    {
        return view('autores.create');
    }

    public function store(AutorRequest $request): RedirectResponse
    {
        $data = [
            'Nome' => $request->input('nome'),
        ];

        $autor = Autor::create($data);

        return redirect()->route('autores.index')->with('success', 'Autor criado com sucesso.');
    }

    public function edit(Autor $autor)
    {
        return view('autores.edit', compact('autor'));
    }

    public function update(AutorRequest $request, Autor $autor): RedirectResponse
    {
        $data = [
            'Nome' => $request->input('nome'),
        ];

        $autor->update($data);

        return redirect()->route('autores.index')->with('success', 'Autor atualizado com sucesso.');
    }

    public function destroy(Autor $autor): RedirectResponse
    {
        $autor->livros()->detach();
        $autor->delete();
        return redirect()->route('autores.index')->with('success', 'Autor excluído com sucesso.');
    }
}


