<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('report_items')) {
            Schema::create('report_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('report_id')->constrained()->onDelete('cascade');
                $table->unsignedBigInteger('test_type_id')->nullable();
                $table->string('parameter_name');
                $table->string('result_value')->nullable();
                $table->string('normal_range')->nullable();
                $table->string('unit')->nullable();
                $table->text('remarks')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('report_items');
    }
};
