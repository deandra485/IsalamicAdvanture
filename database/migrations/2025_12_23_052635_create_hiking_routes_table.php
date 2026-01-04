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
        Schema::create('hiking_routes', function (Blueprint $table) {
        $table->id(); // WAJIB
        $table->foreignId('mountain_id')
            ->constrained('mountains')
            ->cascadeOnDelete();

        $table->string('nama_jalur', 100);
        $table->enum('tingkat_kesulitan', ['mudah', 'sedang', 'sulit', 'sangat sulit']);
        $table->integer('estimasi_waktu_hari');
        $table->decimal('jarak_km', 5, 2)->nullable();
        $table->text('deskripsi_jalur')->nullable();
        $table->boolean('is_available')->default(true);
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hiking_routes');
    }
};
