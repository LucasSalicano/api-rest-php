<?php

namespace App\Http\Controllers;

use App\Models\Contas;
use App\Models\Operacao;
use App\Models\Usuarios;
use Illuminate\Http\Request;

class UsuarioController extends BaseController
{

    public function __construct()
    {
        $this->classe = Usuarios::class;
    }

    public function store(Request $request)
    {
        $usuario = Usuarios::where('cpf', $request->cpf)->count();

        if ($usuario == 1) {
            return response()
                ->json([
                    "erro" => "Já existe um usuário com o mesmo CPF cadastrado."
                ], 400);
        }

        if (strlen($request->cpf) != 11) {
            return response()
                ->json([
                    "erro" => "O CPF informado é inválido."
                ], 400);
        }

        return response()
            ->json(Usuarios::create($request->all()), 201);
    }

    public function destroy(int $id)
    {
        $totalContas = Contas::where("usuarios_id", $id)->count();

        if ($totalContas > 0) {
            return response()->json([
                "erro" => 'Não é possivel excluir o usuario, pois existe movimentações.'
            ], 404);
        }

        $usuario = Usuarios::find($id);
        $usuario->delete();

        return response()->json([], 204);
    }

}
