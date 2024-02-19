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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tutor_id')->constrained('users');
            $table->foreignId('student_id')->nullable()->constrained('users');
            $table->foreignId('parent_id')->nullable()->constrained('users');
            // $table->foreignId('order_id')->constrained('orders');
            $table->foreignId('subject_id')->constrained('subjects');

            $table->string('booking_date')->nullable();
            $table->string('booking_time')->nullable();

            // $table->enum('location',['Physical','Virtual']);
            $table->string('meeting_id',100)->nullable();

            $table->text('meet_start_url')->nullable();
            $table->text('meet_join_url')->nullable();
            $table->string('meet_pass')->nullable();

            $table->integer('duration')->default(60)->nullable()->comment('In minutes');
            $table->string('lessons_schedule',255)->nullable();
            $table->integer('booking_rescheduled_count')->default('0');

            $table->enum('status',['Pending','Scheduled','In Process','Completed','Cancelled By Tutor','Cancelled By User']);
            $table->string('cancellation_reason',255)->nullable();
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
        Schema::dropIfExists('bookings');
    }
};
