<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

use Illuminate\Support\Facades\DB;

$tables = ['reports', 'report_items', 'bookings', 'booking_items', 'patients', 'equipment', 'tasks', 'payments'];

DB::statement('SET FOREIGN_KEY_CHECKS=0;');
foreach ($tables as $table) {
    try {
        DB::table($table)->truncate();
        echo "Truncated $table\n";
    } catch (\Exception $e) {
        echo "Error truncating $table: " . $e->getMessage() . "\n";
    }
}
DB::statement('SET FOREIGN_KEY_CHECKS=1;');
echo "Database cleanup completed.\n";
