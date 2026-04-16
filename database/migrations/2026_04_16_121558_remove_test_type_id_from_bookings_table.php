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
            // Check if the foreign key exists before dropping
            $fkName = 'bookings_test_type_id_foreign';
            $sm = DB::select("SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_NAME = 'bookings' AND COLUMN_NAME = 'test_type_id' AND CONSTRAINT_NAME = ?", [$fkName]);
            Schema::table('bookings', function (Blueprint $table) use ($fkName, $sm) {
                if (!empty($sm)) {
                    $table->dropForeign([$fkName]);
                }
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
