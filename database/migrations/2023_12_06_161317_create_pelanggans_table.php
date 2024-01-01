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
        Schema::create('pelanggans', function (Blueprint $table) {
            $table->id();
            $table->enum('type',['default','reseller','dropshipper'])->default('default');
            $table->string('name');
            $table->string('no_telp');
            $table->string('email')->nullable();
            $table->string('province')->nullable();
            $table->string('city');
            $table->string('subdistrict');
            $table->string('kelurahan')->nullable();
            $table->string('code_province')->nullable();
            $table->string('code_city')->nullable();
            $table->string('code_subdistrict')->nullable();
            $table->string('contact_lain')->nullable();
            $table->text('address');
            $table->foreignId('reseller_id')->nullable();
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
        Schema::dropIfExists('pelanggans');
    }
};
