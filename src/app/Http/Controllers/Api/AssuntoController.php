<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssuntoRequest;
use App\Http\Resources\AssuntoResource;
use App\Models\Assunto;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class AssuntoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = (int) $request->query('per_page', 15);

        $query = Assunto::with(['livros'])->orderBy('Descricao');

        if ($request->has('search')) {
            $q = $request->query('search');
            $query->where('Descricao', 'like', "%{$q}%");
        }

        $pag = $query->paginate($perPage);

        return AssuntoResource::collection($pag);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AssuntoRequest $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $data = [
                    'Descricao' => $request->input('descricao'),
                ];

                $assunto = Assunto::create($data);

                if ($request->filled('livros')) {
                    $assunto->livros()->sync($request->input('livros'));
                }

                $assunto->load(['livros']);

                return new AssuntoResource($assunto);
            });
        } catch (ValidationException $e) {
            return response()->json(['erro' => $e->errors()], 422);
        } catch (QueryException $e) {
            \Log::error('DB Error storing Assunto: '.$e->getMessage());
            return response()->json(['erro' => 'Erro ao acessar o banco de dados.'], 500);
        } catch (\Exception $e) {
            \Log::error('Unexpected Error storing Assunto: '.$e->getMessage());
            return response()->json(['erro' => 'Erro inesperado.'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $assunto = Assunto::with(['livros'])->find($id);
        if (! $assunto) {
            return response()->json(['erro' => 'Assunto não encontrado.'], 404);
        }
        return new AssuntoResource($assunto);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AssuntoRequest $request, $id)
    {
        try {
            return DB::transaction(function () use ($request, $id) {
                $assunto = Assunto::find($id);
                if (! $assunto) {
                    return response()->json(['erro' => 'Assunto não encontrado.'], 404);
                }

                $data = [
                    'Descricao' => $request->input('descricao'),
                ];

                $assunto->update($data);

                if ($request->has('livros')) {
                    $assunto->livros()->sync($request->input('livros'));
                }

                $assunto->load(['livros']);
                return new AssuntoResource($assunto);
            });
        } catch (ValidationException $e) {
            return response()->json(['erro' => $e->errors()], 422);
        } catch (QueryException $e) {
            \Log::error('DB Error updating Assunto: '.$e->getMessage());
            return response()->json(['erro' => 'Erro ao acessar o banco de dados.'], 500);
        } catch (\Exception $e) {
            \Log::error('Unexpected Error updating Assunto: '.$e->getMessage());
            return response()->json(['erro' => 'Erro inesperado.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $assunto = Assunto::find($id);
            if (! $assunto) {
                return response()->json(['erro' => 'Assunto não encontrado.'], 404);
            }
            $assunto->livros()->detach();
            $assunto->delete();
            return response()->json(['mensagem' => 'Assunto removido com sucesso.']);
        } catch (QueryException $e) {
            \Log::error('DB Error deleting Assunto: '.$e->getMessage());
            return response()->json(['erro' => 'Erro ao acessar o banco de dados.'], 500);
        } catch (\Exception $e) {
            \Log::error('Unexpected Error deleting Assunto: '.$e->getMessage());
            return response()->json(['erro' => 'Erro inesperado.'], 500);
        }
    }
}
