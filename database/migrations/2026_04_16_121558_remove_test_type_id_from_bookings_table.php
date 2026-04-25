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
        if (Schema::hasColumn('bookings', 'test_type_id')) {
            try {
                Schema::table('bookings', function (Blueprint $table) {
                    // Try to drop by column name first
                    $table->dropForeign(['test_type_id']);
                });
            } catch (\Exception $e) {
                // If it fails, maybe it doesn't have a foreign key or it has a different name
            }

            Schema::table('bookings', function (Blueprint $table) {
                $table->dropColumn('test_type_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->unsignedBigInteger('test_type_id')->nullable()->after('patient_id');
            $table->foreign('test_type_id')->references('id')->on('test_types')->onDelete('cascade');
        });
    }
};
