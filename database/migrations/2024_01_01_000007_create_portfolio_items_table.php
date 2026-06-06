<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolio_items', function (Blueprint $table) {
            $table->id();
            $table->string('parent_category');   // photography | videography | graphics
            $table->string('sub_category');       // graduation | wedding | etc.
            $table->string('title');
            $table->string('size')->default('');  // feature | wide | tall | ""
            $table->string('image_url');
            $table->string('image_path')->nullable();
            $table->string('video_url')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolio_items');
    }
};
