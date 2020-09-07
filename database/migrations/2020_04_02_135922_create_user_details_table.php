<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->integer('user_id');
            $table->string('phone')->nullable();
            $table->string('expert_category')->nullable();
            $table->string('expert_subcategory')->nullable();
            $table->string('speciality')->nullable();
            $table->string('extra_speciality')->nullable();
            $table->string('profession')->nullable();
            $table->text('bio')->nullable();
            $table->integer('expertise_rate')->default(0);
            $table->integer('general_reputation_score')->default(0);
            $table->integer('expert_reputation_score')->default(0);
            $table->integer('balance')->default(0);
            $table->string('website')->nullable();
            $table->string('country')->nullable();
            $table->string('hometown')->nullable();
            $table->string('contactmail')->nullable();
            $table->string('street')->nullable();
            $table->string('profile_title')->nullable();
            $table->string('graduation')->nullable();
            $table->string('college')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('city')->nullable();
            $table->string('fblink')->nullable();
            $table->string('twitterlink')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('googleplus')->nullable();
            $table->string('paypalEmail')->nullable();
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
        Schema::dropIfExists('user_details');
    }
}
