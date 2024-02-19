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
            $table->id();
            $table->string('first_name',100);
            $table->string('last_name', 100);
            $table->string('email', 100)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 100);
            $table->string('phone', 100);
            $table->enum('gender',['Male','Female']);
            $table->date('dob')->nullable();
            $table->string('facebook_link', 100);
            $table->string('linkedin_link', 100);
            $table->string('twitter_link', 100);
            $table->unsignedBigInteger('role_id')->constrained('roles');
            $table->enum('status',['Pending','Active', 'InActive']);
            $table->text('profile_description');
            $table->string('image',100);
            $table->string('address', 250);
            $table->integer('parent_authority')->default('0');
            $table->integer('tutor_reschedule_warning')->default('0');
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
