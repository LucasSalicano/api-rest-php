<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model
{
    protected $fillable = ['nome', 'cpf', 'data_nascimento'];

    public function Contas()
    {
        $this->belongsTo(Contas::class);
    }
}
