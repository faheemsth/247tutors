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
        //
        Schema::create('help_desks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('assigned_to')->constrained('users');
            $table->string('subject');
            $table->string('description');
            $table->enum('status',['Open','In Progress', 'Resolved', 'Closed']);
            $table->enum('priority',['High','Medium', 'Low']);
            $table->date('closed_date');
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
        //
        Schema::dropIfExists('help_desks');
    }
};
