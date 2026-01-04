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
        Schema::create('payments', function (Blueprint $table) {
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->decimal('jumlah_bayar', 10, 2);
            $table->enum('metode_pembayaran', ['transfer_bank', 'e_wallet', 'cod']);
            $table->enum('status_pembayaran', ['pending', 'verified', 'failed', 'refunded'])->default('pending');
            $table->timestamp('tanggal_pembayaran')->useCurrent();
            $table->string('bukti_pembayaran_url')->nullable();
            $table->text('catatan')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
