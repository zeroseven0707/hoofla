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
        Schema::create('comissions', function (Blueprint $table) {
            $table->id();
            $table->enum('type',['deposit','withdraw','komisi']);
            $table->foreignId('reseller_id');
            $table->enum('status',['progress','success'])->default('progress');
            $table->foreignId('transaction_id');
            $table->double('saldo_awal');
            $table->double('value');
            $table->double('saldo_akhir');
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
        Schema::dropIfExists('comissions');
    }
};
