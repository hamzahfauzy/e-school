<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignToRoleUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('role_user', function (Blueprint $table) {
            //
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('role_user', function (Blueprint $table) {
            //
            $table->dropForeign(['role_id']);
            $table->dropForeign(['user_id']);
        });
    }
}
