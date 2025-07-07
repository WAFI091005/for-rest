<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image')->nullable(); // Gambar kategori opsional
            $table->integer('memories_count')->default(0); // Jumlah kenangan, default 0
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('categories');
    }

};
