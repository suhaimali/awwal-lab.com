<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('bookings')->get()->each(function ($booking) {
            $totalAmount = $booking->amount ?? 0;
            $discount = $booking->discount ?? 0;
            $finalPayable = $totalAmount - $discount;

            DB::table('bookings')
                ->where('id', $booking->id)
                ->update([
                    'total_amount' => $totalAmount ?? 0,
                    'discount' => $discount ?? 0,
                    'final_payable' => $finalPayable ?? 0,
                ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('bookings')->update([
            'total_amount' => null,
            'discount' => null,
            'final_payable' => null,
        ]);
    }
}