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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id(); // WAJIB
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('package_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('booking_type', ['equipment', 'package', 'both']);
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->integer('durasi_hari');
            $table->decimal('total_biaya', 10, 2);
            $table->enum('status_booking', ['pending', 'confirmed', 'ongoing', 'completed', 'cancelled'])->default('pending');
            $table->enum('metode_pengambilan', ['pickup', 'delivery']);
            $table->text('alamat_pengiriman')->nullable();
            $table->text('catatan_customer')->nullable();
            $table->text('catatan_admin')->nullable();
            $table->foreignId('confirmed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
