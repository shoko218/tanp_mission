<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lovers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('last_name',32);
            $table->string('first_name',32);
            $table->string('last_name_furigana',64)->nullable();
            $table->string('first_name_furigana',64)->nullable();
            $table->date('birthday');
            $table->tinyInteger('gender');
            $table->string('postal_code',10)->nullable();
            $table->unsignedBigInteger('prefecture_id')->nullable();
            $table->string('address',200)->nullable();
            $table->string('telephone',21)->nullable();
            $table->unsignedBigInteger('relationship_id')->nullable();;
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('prefecture_id')->references('id')->on('prefectures')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('relationship_id')->references('id')->on('relationships')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lovers');
    }
}
