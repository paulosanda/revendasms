<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignkeyrevendaid extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('master_disparos', function (Blueprint $table) {
            $table->biginteger('revenda_id')->unsigned()->after('id');
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
        Schema::table('master_disparos', function (Blueprint $table) {
            $table->dropForeign('revenda_id');
            $table->dropColumn('revenda_id');
        });
    }
}
