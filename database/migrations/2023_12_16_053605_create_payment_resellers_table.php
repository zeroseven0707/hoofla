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
        Schema::create('payment_resellers', function (Blueprint $table) {
            $table->id();
            $table->string('code_invoice')->unique();
            $table->double('total');
            $table->enum('status',['progress','paid']);
            $table->foreignId('reseller_id');
            $table->foreignId('agen_id');
            $table->foreignId('subagen_id');
            $table->foreignId('distributor_id');
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
        Schema::dropIfExists('payment_resellers');
    }
};
