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
        Schema::create('mountains', function (Blueprint $table) {
        $table->id(); // WAJIB
        $table->string('nama_gunung', 100);
        $table->string('lokasi', 200);
        $table->integer('ketinggian');
        $table->enum('tingkat_kesulitan', ['mudah', 'sedang', 'sulit', 'sangat sulit']);
        $table->text('deskripsi')->nullable();
        $table->string('image_url')->nullable();
        $table->boolean('is_active')->default(true);
        $table->foreignId('created_by')->nullable()
            ->constrained('users')
            ->nullOnDelete();
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mountains');
    }
};
