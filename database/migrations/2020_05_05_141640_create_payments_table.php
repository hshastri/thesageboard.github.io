<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->string('payment_id');
            $table->integer('question_id');
            $table->integer('user_id')->nullable();
            $table->integer('expert_id')->nullable();
            $table->integer('cost_id')->nullable();
            $table->string('amount');
            $table->enum('status',['Pending','Earnings','Withdrawal','Cost'])->default('Pending');
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
        Schema::dropIfExists('payments');
    }
}
