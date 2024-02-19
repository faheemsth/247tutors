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
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->string('wallet_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->decimal('balance', 64, 0)->default(0);
            $table->decimal('net_income', 64, 0)->default(0);
            $table->decimal('withdrawn', 64, 0)->default(0);
            $table->decimal('spent', 64, 0)->default(0);

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
        Schema::dropIfExists('wallet');
    }
};
