<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterLoversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lovers', function (Blueprint $table) {
            $table->boolean('is_there_img')->default('0');
            $table->string('last_name_furigana',64)->nullable(false)->change();
            $table->string('first_name_furigana',64)->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lovers', function (Blueprint $table) {
            $table->dropColumn('is_there_img');
            $table->string('last_name_furigana',64)->nullable()->change();
            $table->string('first_name_furigana',64)->nullable()->change();
        });
    }
}
