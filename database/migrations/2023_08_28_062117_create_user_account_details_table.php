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
        Schema::create('user_account_details', function (Blueprint $table) {
            $table->id();
            $table->string('account_holder_name',100);
            $table->string('bank_name',100);
            $table->string('card_number',100);
            $table->integer('cvc');
            $table->string('card_expire',100);
            $table->enum('account_status',['Active','InActive']);
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
        Schema::dropIfExists('user_account_details');
    }
};
