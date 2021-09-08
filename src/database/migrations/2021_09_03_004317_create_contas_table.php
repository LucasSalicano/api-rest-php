<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        Schema::create('contas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('usuarios_id');
            $table->unsignedInteger('tipo_conta_id');
            $table->float('saldo')->default(0);
            $table->timestamps();

            $table->foreign('usuarios_id')
                ->references('id')
                ->on('usuarios');

            $table->foreign('tipo_conta_id')
                ->references('id')
                ->on('tipo_conta');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contas');
    }
}
