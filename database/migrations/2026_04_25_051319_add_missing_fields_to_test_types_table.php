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
        Schema::table('test_types', function (Blueprint $table) {
            if (!Schema::hasColumn('test_types', 'test_code')) {
                $table->string('test_code')->unique()->after('id');
            }
            if (!Schema::hasColumn('test_types', 'lab_id')) {
                $table->unsignedBigInteger('lab_id')->nullable()->after('category');
                $table->foreign('lab_id')->references('id')->on('labs')->onDelete('cascade');
            }
            if (!Schema::hasColumn('test_types', 'parameters')) {
                $table->json('parameters')->nullable()->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('test_types', function (Blueprint $table) {
            //
        });
    }
};
