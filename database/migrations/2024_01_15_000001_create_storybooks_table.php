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
        Schema::create('storybooks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author');
            $table->string('cover_image')->nullable();
            $table->json('languages')->comment('Available languages: ["en", "hi"]');
            $table->text('description')->nullable();
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->integer('page_count')->default(0);
            $table->string('age_group')->nullable()->comment('e.g., "3-5", "6-8"');
            $table->json('tags')->nullable()->comment('Story tags for categorization');
            $table->timestamps();
            
            // Indexes for performance
            $table->index('status');
            $table->index('author');
            $table->index(['status', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('storybooks');
    }
};