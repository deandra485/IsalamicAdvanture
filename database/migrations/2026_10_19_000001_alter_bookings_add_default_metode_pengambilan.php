<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Set default value 'pickup' agar kolom tidak wajib diisi saat insert
        DB::statement("ALTER TABLE bookings MODIFY metode_pengambilan ENUM('pickup', 'delivery') NOT NULL DEFAULT 'pickup'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE bookings MODIFY metode_pengambilan ENUM('pickup', 'delivery') NOT NULL");
    }
};
