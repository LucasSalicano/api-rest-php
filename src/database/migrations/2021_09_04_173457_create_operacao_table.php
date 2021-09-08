<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOperacaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        Schema::create('operacao', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contas_id')->unsigned();
            $table->integer('conta_destino_id')->nullable();
            $table->string('tipo');
            $table->float('valor');
            $table->timestamps();

            $table->foreign('contas_id')
                ->references('id')
                ->on('contas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('operacao');
    }
}
