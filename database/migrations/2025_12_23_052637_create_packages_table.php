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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
           $table->foreignId('mountain_id')->constrained()->onDelete('cascade');
            $table->string('nama_paket', 100);
            $table->text('deskripsi')->nullable();
            $table->decimal('harga_paket', 10, 2);
            $table->integer('durasi_hari');
            $table->date('tanggal_mulai')->nullable(); 
        $table->date('tanggal_selesai')->nullable();
            $table->integer('max_peserta');
            $table->boolean('include_guide')->default(false);
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
