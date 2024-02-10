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
        Schema::create('variations', function (Blueprint $table) {
            $table->id();
            $table->text('slug')->unique();
            $table->foreignId('product_id');
            $table->string('sku');
            $table->string('warna');
            $table->string('size');
            $table->double('price');
            $table->double('reseller_price');
            $table->double('dropshipper_price');
            $table->double('agen_price');
            $table->double('distributor_price');
            $table->integer('stok');
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
        Schema::dropIfExists('variations');
    }
};
