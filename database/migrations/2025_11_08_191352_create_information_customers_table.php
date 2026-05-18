<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('information_customers', function (Blueprint $table) {
            $table->id();
            $table->string('name_customer')->nullable();
            $table->string('phone_customer')->nullable();
            $table->string('name_account_bank_customer')->nullable();
            $table->string('number_account_bank_customer')->nullable();
            $table->string('address_customer')->nullable();
            $table->string('number_items')->nullable();
            $table->foreignId('picture_id')->constrained()->cascadeOnDelete();
            $table->boolean('is_sent')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('information_customers');
    }
};
