<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class AddForeignkeyrevendaidondisparos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('disparos', function (Blueprint $table) {
            $table->biginteger('revenda_id')->unsigned()->after('empresa_id');
            $table->foreign('revenda_id')->references('id')->on('revendas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('disparos', function (Blueprint $table) {
            $table->dropForeign('revenda_id');
            $table->dropColumn('revenda_id');
        });
    }
}
