<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('exam_item_id')->unsigned();
            $table->bigInteger('question_answer_id')->unsigned()->nullable();
            $table->integer('student_id');
            $table->longText('question_answer_text')->nullable();
            $table->timestamps();

            $table->foreign('exam_item_id')->references('id')->on('exam_items')->onDelete('cascade');
            $table->foreign('question_answer_id')->references('id')->on('question_answers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exam_answers');
    }
}
