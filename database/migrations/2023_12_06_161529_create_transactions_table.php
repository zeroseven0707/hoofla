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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('code_inv')->unique();
            $table->enum('type',['default','distributor','reseller','dropshipper','agen','sub agen'])->default('default');
            $table->foreignId('pelanggan_id')->nullable();
            $table->foreignId('distributor_id')->nullable();
            $table->foreignId('reseller_id')->nullable();
            $table->foreignId('dropshipper_id')->nullable();
            $table->foreignId('payment_reseller')->nullable();
            $table->double('total_bayar')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('shipping_method')->nullable();
            $table->double('cost')->nullable();
            $table->string('penerima')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kota')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('alamat_lengkap')->nullable();
            $table->text('catatan')->nullable();
            // $table->foreignId('variations_id')->nullable();
            $table->enum('status',['progress','pending','paid','expired'])->default('progress');
            $table->boolean('processed')->default(false);
            $table->double('commission')->nullable();
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
        Schema::dropIfExists('transactions');
    }
};
