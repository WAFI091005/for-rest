<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type'); // Nama class notification (misal App\Notifications\ArticleLiked)
            $table->morphs('notifiable'); // notifiable_id dan notifiable_type (biasanya user)
            $table->text('data'); // Data notifikasi yang dikirim
            $table->timestamp('read_at')->nullable(); // Kapan notifikasi dibaca
            $table->timestamps(); // created_at dan updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
