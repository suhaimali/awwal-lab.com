<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Schema::create('payments', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
        //     $table->decimal('amount', 8, 2);
        //     $table->enum('method', ['cash', 'upi', 'card']);
        //     $table->enum('status', ['paid', 'unpaid'])->default('unpaid');
        //     $table->timestamps();
        // });
    }
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
