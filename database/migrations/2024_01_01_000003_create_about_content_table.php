<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('about_content', function (Blueprint $table) {
            $table->id();
            $table->string('eyebrow')->default('About Keenkings Media');
            $table->string('heading')->default('Zambia Creative Production Studio');
            $table->text('lead_text');
            $table->text('body_text');
            $table->string('main_image_url')->nullable();
            $table->string('main_image_path')->nullable();
            $table->string('accent_image_url')->nullable();
            $table->string('accent_image_path')->nullable();
            $table->string('founded_year')->default('2016');
            $table->string('pillar_1')->default('Vision');
            $table->string('pillar_2')->default('Precision');
            $table->string('pillar_3')->default('Passion');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_content');
    }
};
