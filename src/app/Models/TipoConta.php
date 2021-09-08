<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoConta extends Model
{
    protected $fillable = ['nome'];

    public function contas()
    {
        $this->belongsTo(Contas::class);
    }
}
