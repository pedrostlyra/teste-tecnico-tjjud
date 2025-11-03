<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AutorRequest;
use App\Http\Resources\AutorResource;
use App\Models\Autor;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class AutorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = (int) $request->query('per_page', 15);

        $query = Autor::orderBy('Nome');

        if ($request->has('search')) {
            $q = $request->query('search');
            $query->where('Nome', 'like', "%{$q}%");
        }

        $pag = $query->paginate($perPage);

        return AutorResource::collection($pag);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AutorRequest $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $data = [
                    'Nome' => $request->input('nome'),
                ];

                $autor = Autor::create($data);

                return new AutorResource($autor);
            });
        } catch (ValidationException $e) {
            return response()->json(['erro' => $e->errors()], 422);
        } catch (QueryException $e) {
            \Log::error('DB Error storing Autor: '.$e->getMessage());
            return response()->json(['erro' => 'Erro ao acessar o banco de dados.'], 500);
        } catch (\Exception $e) {
            \Log::error('Unexpected Error storing Autor: '.$e->getMessage());
            return response()->json(['erro' => 'Erro inesperado.'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $autor = Autor::find($id);
        if (!$autor) {
            return response()->json(['erro' => 'Autor não encontrado.'], 404);
        }
        return new AutorResource($autor);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AutorRequest $request, $id)
    {
        try {
            return DB::transaction(function () use ($request, $id) {
                $autor = Autor::find($id);
                if (!$autor) {
                    return response()->json(['erro' => 'Autor não encontrado.'], 404);
                }

                $data = [
                    'Nome' => $request->input('nome'),
                ];

                $autor->update($data);

                return new AutorResource($autor);
            });
        } catch (ValidationException $e) {
            return response()->json(['erro' => $e->errors()], 422);
        } catch (QueryException $e) {
            \Log::error('DB Error updating Autor: '.$e->getMessage());
            return response()->json(['erro' => 'Erro ao acessar o banco de dados.'], 500);
        } catch (\Exception $e) {
            \Log::error('Unexpected Error updating Autor: '.$e->getMessage());
            return response()->json(['erro' => 'Erro inesperado.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $autor = Autor::find($id);
            if (!$autor) {
                return response()->json(['erro' => 'Autor não encontrado.'], 404);
            }
            $autor->delete();
            return response()->json(['mensagem' => 'Autor removido com sucesso.']);
        } catch (QueryException $e) {
            \Log::error('DB Error deleting Autor: '.$e->getMessage());
            return response()->json(['erro' => 'Erro ao acessar o banco de dados.'], 500);
        } catch (\Exception $e) {
            \Log::error('Unexpected Error deleting Autor: '.$e->getMessage());
            return response()->json(['erro' => 'Erro inesperado.'], 500);
        }
    }
}
