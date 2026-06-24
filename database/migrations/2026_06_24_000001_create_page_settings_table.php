<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_settings', function (Blueprint $table) {
            $table->id();

            // Hero section
            $table->string('hero_tag', 100)->nullable();
            $table->string('hero_title', 200)->nullable();
            $table->text('hero_description')->nullable();
            $table->string('hero_cta_primary', 100)->nullable();
            $table->string('hero_cta_secondary', 100)->nullable();

            // Ticker
            $table->json('ticker_items')->nullable();

            // Portfolio preview section (home page)
            $table->string('portfolio_section_tag', 100)->nullable();
            $table->string('portfolio_section_title', 200)->nullable();

            // Parallax Banner 1
            $table->string('parallax1_image_url', 500)->nullable();
            $table->string('parallax1_image_path', 500)->nullable();
            $table->string('parallax1_tag', 100)->nullable();
            $table->string('parallax1_title', 200)->nullable();
            $table->text('parallax1_body')->nullable();
            $table->string('parallax1_cta', 100)->nullable();

            // Services section headings
            $table->string('services_tag', 100)->nullable();
            $table->string('services_title', 200)->nullable();
            $table->text('services_description')->nullable();

            // Clients section headings
            $table->string('clients_tag', 100)->nullable();
            $table->string('clients_title', 200)->nullable();

            // Parallax Banner 2
            $table->string('parallax2_image_url', 500)->nullable();
            $table->string('parallax2_image_path', 500)->nullable();
            $table->string('parallax2_tag', 100)->nullable();
            $table->string('parallax2_title', 200)->nullable();
            $table->text('parallax2_body')->nullable();

            // Process section headings
            $table->string('process_tag', 100)->nullable();
            $table->string('process_title', 200)->nullable();

            // Parallax Banner 3
            $table->string('parallax3_image_url', 500)->nullable();
            $table->string('parallax3_image_path', 500)->nullable();
            $table->string('parallax3_title', 200)->nullable();
            $table->text('parallax3_body')->nullable();
            $table->string('parallax3_cta', 100)->nullable();

            // Contact section
            $table->string('contact_tag', 100)->nullable();
            $table->string('contact_title', 200)->nullable();
            $table->text('contact_description')->nullable();
            $table->string('contact_email', 200)->nullable();
            $table->string('contact_phone', 100)->nullable();
            $table->text('contact_address')->nullable();
            $table->json('contact_services')->nullable();

            // Portfolio page hero
            $table->string('portfolio_page_image_url', 500)->nullable();
            $table->string('portfolio_page_image_path', 500)->nullable();
            $table->string('portfolio_page_tag', 100)->nullable();
            $table->string('portfolio_page_title', 200)->nullable();

            // Blog page hero
            $table->string('blog_page_image_url', 500)->nullable();
            $table->string('blog_page_image_path', 500)->nullable();
            $table->string('blog_page_title', 200)->nullable();

            // Footer
            $table->text('footer_description')->nullable();
            $table->string('footer_copyright', 200)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_settings');
    }
};
