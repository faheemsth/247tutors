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
        Schema::create('tutor_applications', function (Blueprint $table) {
            $table->id();
            $table->integer('tutor_id')->default(0);
            $table->tinyInteger('is_criminal')->default(0);
            $table->text('criminal_description')->nullable();
            $table->integer('tutor_type')->nullable();
            $table->integer('week_hours')->nullable();
            $table->string('available_days')->nullable();
            $table->string('tutoring_slot')->nullable();
            $table->string('is_willing_travel')->nullable();
            $table->integer('traveling_distance')->nullable();
            $table->tinyInteger('allowed_drive')->nullable();
            $table->integer('experience')->nullable();
            $table->text('subjects')->nullable();
            $table->text('teaching_level')->nullable();
            $table->text('tutoring_organisation')->nullable();
            $table->longText('user_id')->nullable();
            $table->string('user_id_status')->default('pending');
            $table->string('user_id_rejected_reason')->nullable();
            $table->date('user_id_expiry')->nullable();
            $table->string('address_proof_status')->default('pending');
            $table->text('address_proof_rejected_reason')->nullable();
            $table->longText('address_proof')->nullable();
            $table->date('address_proof_expiry')->nullable();
            $table->longText('enhaced_dbs')->nullable();
            $table->date('enhaced_dbs_expiry')->nullable();
            $table->string('enhaced_dbs_status')->default('pending');
            $table->text('enhaced_dbs_rejected_reason')->nullable();
            $table->longText('selfie')->nullable();
            $table->string('selfie_status')->default('pending');
            $table->text('selfie_rejected_reason')->nullable();
            $table->tinyInteger('reference')->nullable();
            $table->string('refrance_relationship')->nullable();
            $table->string('refrance_contact_number')->nullable();
            $table->string('refrance_email')->nullable();
            $table->string('gender')->nullable();
            $table->string('biography')->nullable();
            $table->string('address')->nullable();
            $table->tinyInteger('disclaimer')->default(0);
            $table->longText('cv')->nullable();
            $table->string('cv_status')->default('pending');
            $table->text('cv_rejected_reason')->nullable();

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
        Schema::dropIfExists('tutor_applications');
    }
};
