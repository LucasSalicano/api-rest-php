<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contas extends Model
{
    protected $fillable = ['usuarios_id', 'tipo_conta_id', 'saldo'];

    public function usuarios()
    {
        $this->hasMany(Usuarios::class);
    }

    public function tipoConta()
    {
        $this->hasMany(TipoConta::class);
    }
}
