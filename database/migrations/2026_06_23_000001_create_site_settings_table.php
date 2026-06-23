<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('font_preset')->default('keenkings');
            $table->string('custom_serif_name')->nullable();
            $table->string('custom_serif_path')->nullable();
            $table->string('custom_sans_name')->nullable();
            $table->string('custom_sans_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
