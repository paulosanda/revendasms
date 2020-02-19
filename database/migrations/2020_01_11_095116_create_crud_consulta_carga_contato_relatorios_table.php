<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrudConsultaCargaContatoRelatoriosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crud_consulta_carga_contato_relatorios', function (Blueprint $table) {
           
            $table->biginteger('carga_contato_id')->nullable();
            $table->biginteger('cliente_id')->nullable();
            $table->string('cliente_nome')->nullable();
            $table->date('cliente_nascimento')->nullable();
            $table->string('cliente_email')->nullable();
            $table->string('cliente_telefone')->nullable();
            $table->string('cliente_sexo')->nullable();
            $table->string('grupo')->nullable();
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
        Schema::dropIfExists('crud_consulta_carga_contato_relatorios');
    }
}
