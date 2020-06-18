<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('lover_id')->nullable();
            $table->unsignedBigInteger('scene_id')->nullable();;
            $table->date('date');
            $table->string('last_name',32);
            $table->string('first_name',32);
            $table->string('last_name_furigana',64);
            $table->string('first_name_furigana',64);
            $table->string('postal_code',10);
            $table->unsignedBigInteger('prefecture_id')->nullable();;
            $table->string('address',200);
            $table->string('telephone',21);
            $table->tinyInteger('gender')->nullable();
            $table->unsignedTinyInteger('age')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('lover_id')->references('id')->on('lovers')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('scene_id')->references('id')->on('scenes')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('prefecture_id')->references('id')->on('prefectures')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
