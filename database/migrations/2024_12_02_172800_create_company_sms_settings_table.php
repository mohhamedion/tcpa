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
        Schema::create('company_twilio_settings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('from_number')->nullable()->unique();
            $table->string('token')->nullable();
            $table->string('sid')->nullable();
            $table->foreignId('company_id')->unique()->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_sms_settings');
    }
};
