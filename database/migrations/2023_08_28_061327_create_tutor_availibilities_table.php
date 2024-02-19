<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutor_availibilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tutor_id')->constrained('users');
            $table->string('day_of_the_week',100);
            $table->string('start_time');
            $table->string('end_time');
            $table->string('timezone',255);
            $table->string('date_range',255);
            $table->enum('repeat_pattren',['Daily','Week','Month'])->default('Daily');
            $table->enum('status',['Active','InActive']);
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
        Schema::dropIfExists('tutor_availibilities');
    }
};
