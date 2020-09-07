<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferralPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referral_payments', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->string('payment_uid');
            $table->string('amount');
            $table->string('expert_id');
            $table->integer('user_id');
            $table->string('payerID');
            $table->enum('status',['Paid','Unpaid'])->default('Paid');
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
        Schema::dropIfExists('referral_payments');
    }
}
