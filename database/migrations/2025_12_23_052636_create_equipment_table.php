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
        Schema::create('equipment', function (Blueprint $table) {
            $table->id(); // WAJIB
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('nama_peralatan', 100);
            $table->text('deskripsi')->nullable();
            $table->string('merk', 50)->nullable();
            $table->decimal('harga_sewa_perhari', 10, 2);
            $table->integer('stok_tersedia')->default(0);
            $table->enum('kondisi', ['baru', 'baik', 'cukup baik'])->default('baik');
            $table->text('spesifikasi')->nullable();
            $table->boolean('is_available')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};
