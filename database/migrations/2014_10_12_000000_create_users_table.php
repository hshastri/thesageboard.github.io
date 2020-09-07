<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('username',50)->unique()->nullable();
            $table->string('email',50)->unique();
            $table->string('password')->nullable();
            $table->string('avatar')->nullable();
            $table->string('provider_id')->nullable();
            $table->enum('status',['Active','Disable'])->default('Disable');
            $table->enum('type',['Admin','User'])->default('User');
            $table->enum('role',['General','Expertise'])->default('General');
            $table->enum('isLogin',['0','1'])->default('0');
            $table->integer('complete_step')->default('0');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
