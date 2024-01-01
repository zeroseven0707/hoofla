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
        Schema::create('dropshippers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('no_telp');
            $table->string('email');
            $table->string('city');
            $table->string('subdistrict');
            $table->string('kelurahan');
            $table->string('contact_lain');
            $table->text('address');
            $table->foreignId('reseller_id');
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
        Schema::dropIfExists('dropshippers');
    }
};
