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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();

            $table->timestamps();

            $table->string('first_name');

            $table->string('last_name');

            $table->string('language');

            $table->string('status');

            $table->string('phone_number');

            $table->string('verification_code');

            $table->foreignId('agent_id')->references('id')->on('users');

            $table->foreignId('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
