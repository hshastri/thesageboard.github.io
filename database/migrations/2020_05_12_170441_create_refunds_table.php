<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refunds', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->string('payment_id');
            $table->integer('question_id');
            $table->integer('user_id');
            $table->integer('expert_id');
            $table->string('amount');
            $table->string('massage')->nullable();
            $table->enum('status',['Completed','Pending','Suspended'])->default('Pending');
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
        Schema::dropIfExists('refunds');
    }
}
