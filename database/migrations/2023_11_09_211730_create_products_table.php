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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('item_group_name');
            $table->text('description');
            $table->text('spesifikasi')->nullable();
            $table->boolean('sell_this');
            $table->boolean('buy_this');
            $table->boolean('stock_this');
            // $table->decimal('buy_price', 10, 2);
            $table->decimal('sell_price', 10, 2);
            $table->decimal('reseller_sell_price', 10, 2);
            $table->decimal('dropshipper_sell_price', 10, 2)->nullable();
            $table->decimal('agen_sell_price', 10, 2)->nullable();
            $table->decimal('distributor_sell_price', 10, 2)->nullable();
            $table->integer('item_category_id');
            $table->string('category_name')->nullable();
            $table->string('sub_category_name')->nullable();
            $table->json('images');
            $table->integer('brand_id')->nullable();
            $table->boolean('is_active')->default(false);
            $table->boolean('recomendation')->default(false);
            $table->boolean('export')->default(false);
            $table->text('package_content')->nullable();
            $table->decimal('package_weight', 10, 2);
            $table->decimal('package_height', 10, 2)->nullable();
            $table->decimal('package_width', 10, 2)->nullable();
            $table->decimal('package_length', 10, 2)->nullable();
            $table->string('brand_name');
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
        Schema::dropIfExists('products');
    }
};
