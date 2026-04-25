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
        Schema::table('report_items', function (Blueprint $table) {
            if (!Schema::hasColumn('report_items', 'category')) {
                $table->string('category')->nullable()->after('parameter_name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('report_items', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }
};
