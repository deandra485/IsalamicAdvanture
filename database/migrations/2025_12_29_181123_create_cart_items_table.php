<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
    $table->id();

    $table->foreignId('user_id')
          ->constrained()
          ->cascadeOnDelete();

    $table->enum('type', ['equipment', 'package']);

    // PACKAGE (boleh null)
    $table->foreignId('package_id')
          ->nullable()
          ->constrained()
          ->nullOnDelete();

    // EQUIPMENT (boleh null)
    $table->foreignId('equipment_id')
          ->nullable()
          ->constrained()
          ->nullOnDelete();

    $table->unsignedInteger('quantity')->default(1);

    $table->timestamps();
});

    }

    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
