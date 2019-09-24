<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVirtualClassroomChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('virtual_classroom_chats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('virtual_classroom_id')->unsigned();
            $table->integer('user_id'); // for teacher and student
            $table->text('messages');
            $table->timestamps();
            $table->foreign('virtual_classroom_id')->references('id')->on('virtual_classrooms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('virtual_classroom_chats');
    }
}
