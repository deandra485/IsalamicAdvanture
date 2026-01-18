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
        Schema::create('booking_items', function (Blueprint $table) {
    $table->id(); // ✅ WAJIB

    $table->foreignId('booking_id')
        ->constrained()
        ->onDelete('cascade');

    // ✅ HARUS nullable
    $table->foreignId('equipment_id')
        ->nullable()
        ->constrained()
        ->onDelete('cascade');

    // ✅ package juga nullable
    $table->foreignId('package_id')
        ->nullable()
        ->constrained()
        ->onDelete('cascade');

    $table->string('item_type'); // equipment | package

    $table->integer('quantity')->default(1);
    $table->decimal('harga_satuan', 10, 2);
    $table->decimal('subtotal', 10, 2);

    $table->date('tanggal_mulai')->nullable();
    $table->date('tanggal_selesai')->nullable();

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_items');
    }
};
