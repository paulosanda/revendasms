<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCargaContatoRelatoriosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carga_contato_relatorios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->biginteger('empresa_id')->unsigned();
            $table->foreign('empresa_id')->references('id')->on('empresas');
            $table->string('clientes_inserts_ids')->nullable();
            $table->string('cliente_grupo_ids')->nullable();
            $table->integer('telefone_carregado')->nullable();
            $table->integer('telefone_repetido')->nullable();
            $table->string('observacao')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carga_contato_relatorios');
    }
}
