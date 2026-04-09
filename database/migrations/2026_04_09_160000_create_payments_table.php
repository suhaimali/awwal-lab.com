<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('payments')) {
            Schema::create('payments', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('patient_id')->nullable();
                $table->decimal('amount', 10, 2);
                $table->enum('payment_status', ['Paid', 'Pending', 'Failed'])->default('Pending');
                $table->enum('payment_method', ['Cash', 'UPI', 'Card']);
                $table->string('transaction_id')->nullable();
                $table->timestamps();
            });
        } else {
            Schema::table('payments', function (Blueprint $table) {
                if (!Schema::hasColumn('payments', 'patient_id')) {
                    $table->unsignedBigInteger('patient_id')->nullable()->after('id');
                }
                if (!Schema::hasColumn('payments', 'amount')) {
                    $table->decimal('amount', 10, 2)->after('patient_id');
                }
                if (!Schema::hasColumn('payments', 'payment_status')) {
                    $table->enum('payment_status', ['Paid', 'Pending', 'Failed'])->default('Pending')->after('amount');
                }
                if (!Schema::hasColumn('payments', 'payment_method')) {
                    $table->enum('payment_method', ['Cash', 'UPI', 'Card'])->after('payment_status');
                }
                if (!Schema::hasColumn('payments', 'transaction_id')) {
                    $table->string('transaction_id')->nullable()->after('payment_method');
                }
            });
        }
    }
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
