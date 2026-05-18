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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // ឈ្មោះរបស់បង
            
            // ប្តូរពី Email មកជា លេខទូរស័ព្ទវិញ ព្រោះបងចង់ប្រើលេខទូរស័ព្ទការពារ
            $table->string('phone_number')->unique(); 
            
            $table->string('password'); // ពាក្យសម្ងាត់
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
