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
        Schema::create('tutor_qualification_attachements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('qualification_id')->constrained('turor_qualifications');
            $table->string('attachement',255);
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
        Schema::dropIfExists('tutor_qualification_attachements');
    }
};
