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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->integer('contact_id')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->text('no_wa')->nullable();
            $table->text('no_ktp')->nullable();
            $table->text('foto_ktp')->nullable();
            $table->text('province')->nullable();
            $table->text('city')->nullable();
            $table->text('subdistrict')->nullable();
            $table->string('code_province')->nullable();
            $table->string('code_city')->nullable();
            $table->string('code_subdistrict')->nullable();
            $table->text('address')->nullable();
            $table->integer('nomor_rekening')->nullable();
            $table->string('account_holders_name')->nullable();
            $table->enum('level',['admin','reseller','agen','sub agen','distributor'])->default('reseller');
            $table->integer('code_category')->nullable();
            $table->enum('status',['active','non active'])->default('non active');
            $table->foreignId('grade_id')->default(1);
            $table->foreignId('bank_id')->nullable();
            $table->double('commission')->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
