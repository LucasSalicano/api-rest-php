<?php

namespace App\Models;

use Illuminate\Http\Request;

interface Recursos
{
    public function deposito(Request $request);

    public function saque(Request $request);

    public function transferencia(Request $request);
}
