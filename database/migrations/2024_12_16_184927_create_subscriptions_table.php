<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Plan name (e.g., Free, Core, Growth, Premium)
            $table->decimal('price', 8, 2); // Price per month
            $table->integer('qr_codes_limit'); // QR Codes limit
            $table->integer('links_limit'); // Links limit
            $table->integer('landing_pages_limit'); // Custom landing pages limit
            $table->integer('back_halves_limit'); // Custom back-halves limit
            $table->integer('click_data_duration'); // Duration for storing click data (in days)
            $table->boolean('utm_builder')->default(false); // UTM Builder feature availability
            $table->boolean('qr_customizations')->default(false); // QR Code customizations
            $table->boolean('redirects')->default(false); // Link & QR redirects
            $table->boolean('custom_domain')->default(false); // Complimentary custom domain
            $table->boolean('branded_links')->default(false); // Branded links
            $table->integer('bulk_link_shortening_limit')->nullable(); // Bulk link shortening limit
            $table->integer('click_scan_data_duration')->nullable(); // Click & scan data duration
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
