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
        Schema::create('sms_content_templates', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('template');
            $table->string('type');
            $table->string('language');
            $table->foreignId('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->unique(['company_id','language','type']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_content_templates');
    }
};
