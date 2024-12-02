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
        Schema::create('company_sms_settings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('from_number')->nullable()->unique();
            $table->text('template_for_verification_code');
            $table->text('template_for_tcpa_accept');
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
