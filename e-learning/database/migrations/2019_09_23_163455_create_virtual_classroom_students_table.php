<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVirtualClassroomStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('virtual_classroom_students', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('virtual_classroom_id')->unsigned()->nullable();
            $table->integer('student_id');
            $table->integer('status');
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
        Schema::dropIfExists('virtual_classroom_students');
    }
}
