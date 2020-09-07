<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterLoversChangeIsThereImgToImgExtension extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lovers', function (Blueprint $table) {
            $table->dropColumn('is_there_img');
            $table->string('img_extension',10)->nullable();
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
            $table->boolean('is_there_img')->default('0');
            $table->dropColumn('img_extension');
        });
    }
}
