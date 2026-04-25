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
        Schema::table('test_categories', function (Blueprint $table) {
            $table->text('description')->nullable()->after('name');
            $table->string('status')->default('Active')->after('description');
            $table->unsignedBigInteger('lab_id')->default(1)->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('test_categories', function (Blueprint $table) {
            //
        });
    }
};
