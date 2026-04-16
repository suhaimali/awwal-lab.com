<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('payments', 'total')) {
            Schema::table('payments', function (Blueprint $table) {
                $table->decimal('total', 10, 2)->default(0)->change();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('payments', 'total')) {
            Schema::table('payments', function (Blueprint $table) {
                $table->decimal('total', 10, 2)->change();
            });
        }
    }
};