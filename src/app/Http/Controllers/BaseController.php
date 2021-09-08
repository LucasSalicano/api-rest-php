<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class BaseController extends Controller
{
    protected string $classe;

    public function index()
    {
        return $this->classe::paginate();
    }

    public function store(Request $request)
    {
        return response()
            ->json($this->classe::create($request->all()), 201);
    }

    public function show(int $id, Request $request)
    {
        $usuario = $this->classe::find($id);

        if (is_null($usuario)) {
            return response()->json('', 204);
        }

        return $usuario;
    }

    public function update(int $id, Request $request)
    {
        $usuario = $this->classe::find($id);

        if (is_null($usuario)) {
            return response()->json([
                "erro" => 'Recurso não encontrado'
            ], 404);
        }

        $usuario->fill($request->all());
        $usuario->save();

        return $usuario;
    }

    public function destroy(int $id)
    {
        $usuario = $this->classe::destroy($id);

        if ($usuario === 0) {
            return response()->json([
                "erro" => 'Recurso não encontrado'
            ], 404);
        }

        return response()->json([], 204);
    }

}
