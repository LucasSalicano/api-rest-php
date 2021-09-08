<?php

namespace App\Http\Controllers;

use App\Models\Operacao;
use Illuminate\Http\Request;

class ExtratoController extends Controller
{
    public function show(int $contaId, Request $request)
    {
        $extrato = Operacao::where('contas_id', $contaId);

        if (!empty($request->operacao)) {
            $extrato->where('tipo', strtoupper($request->operacao));
        }

        if (!empty($request->dataInicio) && !empty($request->dataFinal)) {
            $dataInicio = (new \DateTime($request->dataInicio))->format('Y-m-d H:i:s');
            $dataFinal = (new \DateTime($request->dataFinal))->format('Y-m-d H:i:s');

            $extrato->wherebetween('created_at', [$dataInicio, $dataFinal]);
        }

        if ($extrato->count() == 0) {
            return response()->json([], 204);
        }

        return response()->json($extrato->orderBy('id', 'desc')->paginate(10));
    }
}
