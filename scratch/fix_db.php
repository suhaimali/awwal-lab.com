<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

if (!Schema::hasColumn('tasks', 'assigned_to')) {
    echo "Adding assigned_to column to tasks table...\n";
    Schema::table('tasks', function (Blueprint $table) {
        $table->unsignedBigInteger('assigned_to')->nullable()->after('status');
        $table->foreign('assigned_to')->references('id')->on('users')->onDelete('cascade');
    });
    echo "Done.\n";
} else {
    echo "assigned_to column already exists.\n";
}
