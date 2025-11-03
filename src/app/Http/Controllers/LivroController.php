<?php

namespace App\Http\Controllers;

use App\Http\Requests\LivroRequest;
use App\Models\Assunto;
use App\Models\Autor;
use App\Models\Livro;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LivroController extends Controller
{
    public function index()
    {
        $livros = Livro::orderBy('Titulo')->paginate(10);
        return view('livros.index', compact('livros'));
    }

    public function create()
    {
        $autores = Autor::orderBy('Nome')->get();
        $assuntos = Assunto::orderBy('Descricao')->get();
        return view('livros.create', compact('autores', 'assuntos'));
    }

    public function store(LivroRequest $request): RedirectResponse
    {
        $data = [
            'Titulo' => $request->input('titulo'),
            'Editora' => $request->input('editora'),
            'Edicao' => $request->input('edicao'),
            'AnoPublicacao' => $request->input('ano_publicacao'),
            'Valor' => $request->input('valor'),
        ];

        $livro = Livro::create($data);

        if ($request->filled('autores')) {
            $livro->autores()->sync($request->input('autores'));
        }
        if ($request->filled('assuntos')) {
            $livro->assuntos()->sync($request->input('assuntos'));
        }

        return redirect()->route('livros.index')->with('success', 'Livro criado com sucesso.');
    }

    public function edit(Livro $livro)
    {
        $autores = Autor::orderBy('Nome')->get();
        $assuntos = Assunto::orderBy('Descricao')->get();
        $livroAutores = $livro->autores()->pluck('Autor_CodAu')->all();
        $livroAssuntos = $livro->assuntos()->pluck('Assunto_CodAs')->all();

        return view('livros.edit', compact('livro', 'autores', 'assuntos', 'livroAutores', 'livroAssuntos'));
    }

    public function update(LivroRequest $request, Livro $livro): RedirectResponse
    {
        $data = [
            'Titulo' => $request->input('titulo'),
            'Editora' => $request->input('editora'),
            'Edicao' => $request->input('edicao'),
            'AnoPublicacao' => $request->input('ano_publicacao'),
            'Valor' => $request->input('valor'),
        ];

        $livro->update($data);

        if ($request->has('autores')) {
            $livro->autores()->sync($request->input('autores', []));
        }
        if ($request->has('assuntos')) {
            $livro->assuntos()->sync($request->input('assuntos', []));
        }

        return redirect()->route('livros.index')->with('success', 'Livro atualizado com sucesso.');
    }

    public function destroy(Livro $livro): RedirectResponse
    {
        $livro->autores()->detach();
        $livro->assuntos()->detach();
        $livro->delete();
        return redirect()->route('livros.index')->with('success', 'Livro excluído com sucesso.');
    }
}


