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
        Schema::create('short_urls_visits', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->unsignedBigInteger('short_url_id');
            $table->string('operating_system')->nullable();
            $table->string('operating_system_version')->nullable();
            $table->string('browser')->nullable();
            $table->string('browser_version')->nullable();
            $table->string('referer_url')->nullable();
            $table->string('device_type')->nullable();
            $table->timestamp('visited_at')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // Foreign key constraint
            $table->foreign('short_url_id')
                  ->references('id')
                  ->on('short_urls')
                  ->onDelete('cascade'); // Cascade delete to remove visits when a short URL is deleted
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('short_urls_visits');
    }
};
