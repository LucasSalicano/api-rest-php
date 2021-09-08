<?php

namespace App\Http\Controllers;

use App\Models\Contas;

class ContaController extends BaseController
{
    public function __construct()
    {
        $this->classe = Contas::class;
    }
}
