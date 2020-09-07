<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_details', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->string('payment_uid');
            $table->integer('user_id');
            $table->integer('question_id');
            $table->enum('payment_status',['Paid','Unpaid'])->default('Unpaid');
            $table->string('paypal_paid_amount')->nullable();
            $table->string('paypal_transaction_id')->nullable();
            $table->string('payerID')->nullable();
            $table->string('paymentID')->nullable();
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
        Schema::dropIfExists('payment_details');
    }
}
