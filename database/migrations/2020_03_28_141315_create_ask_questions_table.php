<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAskQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ask_questions', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->integer('user_id');
            $table->string('question_title',255);
            $table->string('slug',255);
            $table->text('description');
            $table->string('file')->nullable();
            $table->string('tags',255);
            $table->integer('category_id')->nullable();
            $table->integer('subcategory_id')->nullable();
            $table->enum('type',['public','private'])->default('public');
            $table->string('experties_ids')->nullable();
            $table->double('amount', 8, 2)->nullable();
            $table->string('payment_id')->nullable();
            $table->integer('totalview')->default(0);
            $table->integer('totalvote')->default(0);
            $table->integer('totalanswer')->default(0);
            $table->enum('isSolved',['yes','no'])->default('no');
            $table->enum('question_label',['General','Premium'])->default('General');
            $table->enum('viewed',['0','1'])->default('0');
            $table->enum('is_deleted',['0','1'])->default('0');
            $table->string('last_answer_at',255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ask_questions');
    }
}
