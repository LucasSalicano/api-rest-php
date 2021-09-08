<?php

namespace App\Http\Controllers;

use App\Models\Contas;
use App\Models\Operacao;
use Illuminate\Http\Request;

class OperacaoController extends Controller
{
    public function __construct()
    {
        $this->classe = Operacao::class;
    }

    public function store(Request $request)
    {
        $conta = Contas::find($request->contas_id);

        if (is_null($conta)) {
            return response()->json([], 204);
        }

        $uri = explode('/', $request->getRequestUri());
        $tipo = $uri[2];

        $operacao = new Operacao();
        return $operacao->$tipo($request);
    }
}
