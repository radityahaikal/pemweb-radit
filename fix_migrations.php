<?php
require 'vendor/autoload.php';
require 'bootstrap/app.php';

use Illuminate\Support\Facades\DB;

DB::statement('ALTER TABLE migrations MODIFY COLUMN id INT AUTO_INCREMENT');
DB::table('migrations')->insert([
    ['migration' => '0001_01_01_000000_create_users_table', 'batch' => 1],
    ['migration' => '0001_01_01_000001_create_cache_table', 'batch' => 1],
    ['migration' => '0001_01_01_000002_create_jobs_table', 'batch' => 1],
    ['migration' => '2025_12_14_101018_create_bahan_bakus_table', 'batch' => 1],
]);

echo "Migrations table fixed and populated!\n";
