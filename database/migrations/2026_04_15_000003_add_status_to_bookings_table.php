<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Duplicate status column migration commented out to avoid conflict.
        // Schema::table('bookings', function (Blueprint $table) {
        //     $table->enum('status', ['Pending', 'Confirmed', 'Cancelled'])->default('Pending')->after('amount');
        // });
    }

    public function down(): void
    {
        // Schema::table('bookings', function (Blueprint $table) {
        //     $table->dropColumn('status');
        // });
    }
};
