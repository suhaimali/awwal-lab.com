<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings', 'time')) {
                $table->time('time')->nullable()->after('booking_date');
            }
            if (!Schema::hasColumn('bookings', 'booking_date')) {
                $table->date('booking_date')->nullable()->after('test_type');
            }
            if (!Schema::hasColumn('bookings', 'total_amount')) {
                $table->decimal('total_amount', 10, 2)->default(0)->after('status');
            }
            if (!Schema::hasColumn('bookings', 'discount')) {
                $table->decimal('discount', 10, 2)->default(0)->after('total_amount');
            }
            if (!Schema::hasColumn('bookings', 'final_payable')) {
                $table->decimal('final_payable', 10, 2)->default(0)->after('discount');
            }
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['time', 'booking_date', 'total_amount', 'discount', 'final_payable']);
        });
    }
};