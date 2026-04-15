<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['adnamiton_notes', 'lab_test_setup', 'additional_notes']);
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->text('adnamiton_notes')->nullable();
            $table->text('lab_test_setup')->nullable();
            $table->text('additional_notes')->nullable();
        });
    }
};