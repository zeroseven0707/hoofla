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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('category_id');
            $table->integer('brand_id')->nullable();
            $table->text('barcode');
            $table->text('description');

            $table->text('images');

            $table->boolean('sell_this');
            $table->boolean('buy_this');
            $table->boolean('stock_this');
            $table->decimal('default_price', 10, 2);
            $table->decimal('reseller_sell_price', 10, 2);
            $table->decimal('buy_price', 10, 2);
            $table->decimal('sell_price', 10, 2);
            $table->boolean('is_active');
            $table->text('package_content')->nullable();
            $table->decimal('package_weight', 10, 2);
            $table->decimal('package_height', 10, 2)->nullable();
            $table->decimal('package_width', 10, 2)->nullable();
            $table->decimal('package_length', 10, 2)->nullable();
            $table->json('variations');
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
        Schema::dropIfExists('items');
    }
};
