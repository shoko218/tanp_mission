<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('last_name',32);
            $table->string('first_name',32);
            $table->string('last_name_furigana',64);
            $table->string('first_name_furigana',64);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->date('birthday');
            $table->tinyInteger('gender');
            $table->string('postal_code',10)->nullable();
            $table->unsignedBigInteger('prefecture_id')->nullable();
            $table->string('address',200)->nullable();
            $table->string('telephone',21)->nullable();
            $table->rememberToken();
            $table->timestamps();
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
        Schema::dropIfExists('users');
    }
}
