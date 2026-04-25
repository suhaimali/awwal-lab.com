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
            if (!Schema::hasColumn('bookings', 'booking_id')) {
                $table->string('booking_id')->unique()->after('id');
            }
            if (!Schema::hasColumn('bookings', 'bill_no')) {
                $table->string('bill_no')->nullable()->after('booking_id');
            }
            if (!Schema::hasColumn('bookings', 'lab_id')) {
                $table->unsignedBigInteger('lab_id')->nullable()->after('patient_id');
                $table->foreign('lab_id')->references('id')->on('labs')->onDelete('cascade');
            }
            if (!Schema::hasColumn('bookings', 'tests')) {
                $table->json('tests')->nullable()->after('lab_id');
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
