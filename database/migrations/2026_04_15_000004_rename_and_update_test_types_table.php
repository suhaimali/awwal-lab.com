<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Only rename if 'lab_test_types' does not already exist
        if (!Schema::hasTable('lab_test_types') && Schema::hasTable('test_types')) {
            Schema::rename('test_types', 'lab_test_types');
        }

        // Update the renamed table
        if (Schema::hasTable('lab_test_types')) {
            Schema::table('lab_test_types', function (Blueprint $table) {
                if (!Schema::hasColumn('lab_test_types', 'description')) {
                    $table->text('description')->nullable()->after('name');
                }
                if (!Schema::hasColumn('lab_test_types', 'is_active')) {
                    // Add after 'status' if it exists, otherwise after 'name'
                    $after = Schema::hasColumn('lab_test_types', 'status') ? 'status' : 'name';
                    $table->boolean('is_active')->default(true)->after($after);
                }
            });
        }
    }

    public function down(): void
    {
        // Revert the table name
        Schema::rename('lab_test_types', 'test_types');

        // Revert the changes to the table
        Schema::table('test_types', function (Blueprint $table) {
            if (Schema::hasColumn('test_types', 'description')) {
                $table->dropColumn('description');
            }
            if (Schema::hasColumn('test_types', 'is_active')) {
                $table->dropColumn('is_active');
            }
        });
    }
};