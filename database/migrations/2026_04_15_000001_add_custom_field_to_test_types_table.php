<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('test_types', function (Blueprint $table) {
            $table->string('custom_field', 255)->nullable()->after('name');
        });
    }

    public function down(): void
    {
        Schema::table('test_types', function (Blueprint $table) {
            $table->dropColumn('custom_field');
        });
    }
};
