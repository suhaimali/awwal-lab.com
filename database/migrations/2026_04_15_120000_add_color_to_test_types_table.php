<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('test_types', 'color')) {
            Schema::table('test_types', function (Blueprint $table) {
                $table->string('color', 7)->default('#343a40')->after('status');
            });
        }
    }
    public function down(): void
    {
        if (Schema::hasColumn('test_types', 'color')) {
            Schema::table('test_types', function (Blueprint $table) {
                $table->dropColumn('color');
            });
        }
    }
};
