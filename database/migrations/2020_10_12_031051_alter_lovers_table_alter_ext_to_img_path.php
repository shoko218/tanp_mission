<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterLoversTableAlterExtToImgPath extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lovers', function (Blueprint $table) {
            $table->renameColumn('img_extension', 'img_path');
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
            $table->renameColumn('img_path','img_extension');
        });
    }
}
