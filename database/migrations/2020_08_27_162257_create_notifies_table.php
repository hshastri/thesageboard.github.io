<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotifiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifies', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->integer('create_user_id');
            $table->integer('notify_user_id');
            $table->integer('question_id');
            $table->string('notify_title');
            $table->integer('type')->comment('1 for anspublic','2 for ansPrivate','3 for askPrivateQsn' ,'4 acceptAnswer' ,'5 acceptPrivateAns' ,'6 forcomment','7 payment receive');
            $table->enum('seen',['1','0'])->default('0');
            $table->enum('is_read',['1','0'])->default('0');
            $table->enum('status',['1','0'])->default('0');
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
        Schema::dropIfExists('notifies');
    }
}
