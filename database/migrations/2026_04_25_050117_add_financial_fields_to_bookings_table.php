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
        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings', 'advance_amount')) {
                $table->decimal('advance_amount', 15, 2)->default(0)->after('discount');
            }
            if (!Schema::hasColumn('bookings', 'balance_amount')) {
                $table->decimal('balance_amount', 15, 2)->default(0)->after('advance_amount');
            }
        });

        Schema::table('equipment', function (Blueprint $table) {
            if (!Schema::hasColumn('equipment', 'notes')) {
                $table->text('notes')->nullable()->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            //
        });
    }
};
