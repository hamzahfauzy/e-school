<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableStudyTeacher extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('study_teacher', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('study_id')->unsigned();
            $table->bigInteger('employee_id')->unsigned();
            $table->bigInteger('classroom_id')->unsigned();

            $table->foreign('study_id')->references('id')->on('studies')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('classroom_id')->references('id')->on('classrooms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('study_teacher');
    }
}
