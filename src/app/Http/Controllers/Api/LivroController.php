<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LivroRequest;
use App\Http\Resources\LivroResource;
use App\Models\Livro;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class LivroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = (int) $request->query('per_page', 15);

        $query = Livro::with(['autores', 'assuntos'])->orderBy('Titulo');

        if ($request->has('search')) {
            $q = $request->query('search');
            $query->where('Titulo', 'like', "%{$q}%");
        }

        $pag = $query->paginate($perPage);

        return LivroResource::collection($pag);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LivroRequest $request)
    {
        try {
            return DB::transaction(function () use ($request) {
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

                $livro->load(['autores', 'assuntos']);

                return new LivroResource($livro);
            });
        } catch (ValidationException $e) {
            return response()->json(['erro' => $e->errors()], 422);
        } catch (QueryException $e) {
            \Log::error('DB Error storing Livro: '.$e->getMessage());
            return response()->json(['erro' => 'Erro ao acessar o banco de dados.'], 500);
        } catch (\Exception $e) {
            \Log::error('Unexpected Error storing Livro: '.$e->getMessage());
            return response()->json(['erro' => 'Erro inesperado.'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $livro = Livro::with(['autores', 'assuntos'])->find($id);
        if (! $livro) {
            return response()->json(['erro' => 'Livro não encontrado.'], 404);
        }
        return new LivroResource($livro);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LivroRequest $request, $id)
    {
        try {
            return DB::transaction(function () use ($request, $id) {
                $livro = Livro::find($id);
                if (! $livro) {
                    return response()->json(['erro' => 'Livro não encontrado.'], 404);
                }

                $data = [
                    'Titulo' => $request->input('titulo'),
                    'Editora' => $request->input('editora'),
                    'Edicao' => $request->input('edicao'),
                    'AnoPublicacao' => $request->input('ano_publicacao'),
                    'Valor' => $request->input('valor'),
                ];

                $livro->update($data);

                if ($request->has('autores')) {
                    $livro->autores()->sync($request->input('autores'));
                }

                if ($request->has('assuntos')) {
                    $livro->assuntos()->sync($request->input('assuntos'));
                }

                $livro->load(['autores', 'assuntos']);
                return new LivroResource($livro);
            });
        } catch (ValidationException $e) {
            return response()->json(['erro' => $e->errors()], 422);
        } catch (QueryException $e) {
            \Log::error('DB Error updating Livro: '.$e->getMessage());
            return response()->json(['erro' => 'Erro ao acessar o banco de dados.'], 500);
        } catch (\Exception $e) {
            \Log::error('Unexpected Error updating Livro: '.$e->getMessage());
            return response()->json(['erro' => 'Erro inesperado.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $livro = Livro::find($id);
            if (! $livro) {
                return response()->json(['erro' => 'Livro não encontrado.'], 404);
            }
            $livro->autores()->detach();
            $livro->assuntos()->detach();
            $livro->delete();
            return response()->json(['mensagem' => 'Livro removido com sucesso.']);
        } catch (QueryException $e) {
            \Log::error('DB Error deleting Livro: '.$e->getMessage());
            return response()->json(['erro' => 'Erro ao acessar o banco de dados.'], 500);
        } catch (\Exception $e) {
            \Log::error('Unexpected Error deleting Livro: '.$e->getMessage());
            return response()->json(['erro' => 'Erro inesperado.'], 500);
        }
    }
}
