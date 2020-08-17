<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterOrdersTableAddUserInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->renameColumn('last_name','forwarding_last_name');
            $table->renameColumn('first_name','forwarding_first_name');
            $table->renameColumn('last_name_furigana','forwarding_last_name_furigana');
            $table->renameColumn('first_name_furigana','forwarding_first_name_furigana');
            $table->renameColumn('postal_code','forwarding_postal_code');
            $table->renameColumn('prefecture_id','forwarding_prefecture_id');
            $table->renameColumn('address','forwarding_address');
            $table->renameColumn('telephone','forwarding_telephone');

            $table->string('user_last_name',32);
            $table->string('user_first_name',32);
            $table->string('user_last_name_furigana',64);
            $table->string('user_first_name_furigana',64);
            $table->string('user_postal_code',10);
            $table->unsignedBigInteger('user_prefecture_id')->nullable();
            $table->string('user_address',200);
            $table->string('user_telephone',21);

            $table->foreign('user_prefecture_id')->references('id')->on('prefectures')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->renameColumn('forwarding_last_name','last_name');
            $table->renameColumn('forwarding_first_name','first_name');
            $table->renameColumn('forwarding_last_name_furigana','last_name_furigana');
            $table->renameColumn('forwarding_first_name_furigana','first_name_furigana');
            $table->renameColumn('forwarding_postal_code','postal_code');
            $table->renameColumn('forwarding_prefecture_id','prefecture_id');
            $table->renameColumn('forwarding_address','address');
            $table->renameColumn('forwarding_telephone','telephone');

            $table->dropColumn('user_last_name',32);
            $table->dropColumn('user_first_name',32);
            $table->dropColumn('user_last_name_furigana',64);
            $table->dropColumn('user_first_name_furigana',64);
            $table->dropColumn('user_postal_code',10);
            $table->dropColumn('user_prefecture_id')->nullable();
            $table->dropColumn('user_address',200);
            $table->dropColumn('user_telephone',21);

            $table->dropForeign('orders_user_prefecture_id_foreign');
        });
    }
}
