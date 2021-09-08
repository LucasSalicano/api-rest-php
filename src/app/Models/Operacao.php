<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Operacao extends Model implements Recursos
{
    protected $fillable = ['contas_id', 'conta_destino_id', 'tipo', 'valor'];
    protected $table = "operacao";

    const SAQUE = 'SAQUE';
    const DEPOSITO = 'DEPOSITO';
    const TRANSFERENCIA = 'TRANSFERENCIA';

    public function contas()
    {
        $this->hasMany(Contas::class);
    }

    public function deposito(Request $request)
    {
        if (!is_int($request->valor) || $request->valor < 0) {
            return response()->json([
                "erro" => "Não é aceito centavos para deposito ou o não é um valor inteiro positivo."
            ], 400);
        }

        $contas = Contas::find($request->contas_id);
        $contas->saldo += $request->valor;
        $contas->save();

        return self::registraOperacao(self::DEPOSITO, $request);
    }

    public function saque(Request $request)
    {
        $conta = Contas::find($request->contas_id);

        $notas = [
            "100" => 0,
            "50" => 0,
            "20" => 0
        ];

        $verificaSaldo = $this->verificaSaldo($conta->saldo, $request->valor);
        if ($verificaSaldo) {
            return $verificaSaldo;
        }

        $totalSaque = $request->valor;
        foreach ($notas as $nota => $totalNotas) {
            $totalCedulas = (int)($totalSaque / $nota);

            $valor = substr($totalSaque, 0, 1);
            if ($nota == 50 && $valor % 2 == 0) {
                continue;
            }

            if ($totalCedulas > 0) {
                $totalSaque -= ($totalCedulas * $nota);
                $notas[$nota] = $totalCedulas;
            }
        }

        if ($totalSaque == $request->valor) {
            return response()->json([
                "erro" => "Não foi possivel realizar esta operação: Não hà cedulas"
            ]);
        }

        if ($totalSaque > 0) {
            return response()->json([
                "erro" => "Não foi possivel realizar esta operação"
            ], 400);
        }

        self::registraOperacao(self::SAQUE, $request, $conta);
        return response()->json($notas);
    }

    public function transferencia(Request $request)
    {
        $contaOrigem = Contas::find($request->contas_id);
        $this->verificaSaldo($contaOrigem->saldo, $request->valor);

        $contaDestino = Contas::find($request->contas_destino_id);

        if (!is_int($request->valor)) {
            return response()->json([
                "erro" => "Não foi possivel realizar esta operação: valor de negativo."
            ], 400);
        }

        if (is_null($contaDestino)) {
            return response()->json([
                "erro" => "Não foi possivel realizar esta operação: Conta de destino é inválida"
            ], 400);
        }

        $contaDestino->saldo += $request->valor;
        $contaDestino->save();

        $contaOrigem->saldo -= $request->valor;
        $contaOrigem->save();

        return self::registraOperacao(self::TRANSFERENCIA, $request);
    }

    private static function registraOperacao(string $operacao, Request $request, $conta = null)
    {
        $dados = [
            "contas_id" => $request->contas_id,
            "conta_destino_id" => $request->contas_destino_id,
            "tipo" => "{$operacao}",
            "valor" => $request->valor
        ];

        if (!is_null($conta)) {
            $conta->saldo -= $request->valor;
            $conta->save();
        }

        return response()->json([
            self::create($dados)
        ]);
    }

    private function verificaSaldo($saldo, $valorOperacao)
    {
        if ($valorOperacao > $saldo) {
            return response()->json([
                "erro" => "Não foi possivel realizar esta operação: saldo insuficiente"
            ], 400);
        }
    }
}
