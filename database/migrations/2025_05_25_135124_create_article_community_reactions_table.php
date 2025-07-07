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
        Schema::create('article_community_reactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('article_community_id')->constrained()->onDelete('cascade');
            $table->string('type'); // contoh: 'like', 'love', 'laugh'
            $table->timestamps();

            $table->unique(['user_id', 'article_community_id']); // satu reaksi per user per artikel
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_community_reactions');
    }
};
