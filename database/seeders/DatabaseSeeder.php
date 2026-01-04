<?php
// ==========================================
// DATABASE SEEDERS
// ==========================================

// database/seeders/DatabaseSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            MountainSeeder::class,
            HikingRouteSeeder::class,
            EquipmentSeeder::class,
            PackageSeeder::class,
        ]);
    }
}