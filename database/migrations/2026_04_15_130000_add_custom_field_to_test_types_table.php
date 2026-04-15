<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('test_types', 'custom_field')) {
            Schema::table('test_types', function (Blueprint $table) {
                $table->string('custom_field')->nullable()->after('name');
            });
        }
    }
    public function down(): void
    {
        if (Schema::hasColumn('test_types', 'custom_field')) {
            Schema::table('test_types', function (Blueprint $table) {
                $table->dropColumn('custom_field');
            });
        }
    }
};
