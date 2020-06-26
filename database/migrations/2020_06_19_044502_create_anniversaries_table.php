<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('lover_id');
            $table->string('title',30);
            $table->unsignedBigInteger('scene_id')->nullable();
            $table->date('date');
            $table->timestamps();

            $table->foreign('lover_id')->references('id')->on('lovers')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('scene_id')->references('id')->on('scenes')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
