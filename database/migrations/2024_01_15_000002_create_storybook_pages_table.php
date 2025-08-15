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
        Schema::create('storybook_pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('storybook_id')->constrained()->onDelete('cascade');
            $table->integer('page_number');
            $table->json('text_content')->comment('Text content in multiple languages {"en": "...", "hi": "..."}');
            $table->string('image_path')->nullable();
            $table->json('audio_paths')->nullable()->comment('Audio files for different languages {"en": "path", "hi": "path"}');
            $table->json('animation_data')->nullable()->comment('Future animation settings');
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['storybook_id', 'page_number']);
            $table->unique(['storybook_id', 'page_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('storybook_pages');
    }
};