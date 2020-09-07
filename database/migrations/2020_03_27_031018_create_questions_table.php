<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->integer('category_id');
            $table->integer('subcategory_id');
            $table->string('question',255);
            $table->string('type',20)->comment("For 1 radio for 2 select for 3 input");;
            $table->text('multiple_question')->nullable();
            $table->enum('status',['Active','Disable'])->default('Active');
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
        Schema::dropIfExists('questions');
    }
}
