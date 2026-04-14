<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Schema::create('payments', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
        //     $table->foreignId('appointment_id')->nullable()->constrained('appointments')->onDelete('set null');
        //     $table->decimal('amount', 10, 2);
        //     $table->string('payment_method'); // UPI, QR, Cash, Card
        //     $table->string('upi_id')->nullable();
        //     $table->string('qr_code_path')->nullable();
        //     $table->enum('status', ['Paid', 'Pending', 'Failed'])->default('Pending');
        //     $table->text('notes')->nullable();
        //     $table->timestamp('paid_at')->nullable();
        //     $table->timestamps();
        // });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
