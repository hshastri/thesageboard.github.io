<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInviteUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invite_users', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email',50)->unique();
            $table->string('password');
            $table->enum('status',['Active','Pending'])->default('Pending');
            $table->enum('type',['Admin','User'])->default('User');
            $table->enum('role',['General','Expertise'])->default('General');
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
        Schema::dropIfExists('invite_users');
    }
}
