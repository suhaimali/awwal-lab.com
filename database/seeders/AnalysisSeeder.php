<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lab;
use App\Models\TestCategory;
use App\Models\TestType;
use App\Models\Patient;
use App\Models\Booking;
use App\Models\Report;
use App\Models\Payment;
use Carbon\Carbon;

class AnalysisSeeder extends Seeder
{
    public function run()
    {
        // Disable foreign key checks to truncate safely
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Booking::truncate();
        Patient::truncate();
        Report::truncate();
        Payment::truncate();
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        // 1. Create a Lab if not exists
        $lab = Lab::firstOrCreate(['id' => 1], [
            'lab_name' => 'Suhaim Soft Laboratory',
            'description' => 'Main Diagnostic Node'
        ]);

        // 2. Create Categories
        $categories = ['Hematology', 'Biochemistry', 'Serology', 'Radiology'];
        foreach ($categories as $cat) {
            TestCategory::firstOrCreate(['name' => $cat]);
        }

        // 3. Create Test Types
        $tests = [
            ['test_code' => 'CBC01', 'name' => 'Complete Blood Count', 'price' => 500, 'category' => 'Hematology'],
            ['test_code' => 'LIVER02', 'name' => 'Liver Function Test', 'price' => 1200, 'category' => 'Biochemistry'],
            ['test_code' => 'KID03', 'name' => 'Kidney Function Test', 'price' => 950, 'category' => 'Biochemistry'],
            ['test_code' => 'MAL04', 'name' => 'Malaria Parasite', 'price' => 350, 'category' => 'Serology'],
        ];

        foreach ($tests as $t) {
            TestType::firstOrCreate(['test_code' => $t['test_code']], [
                'name' => $t['name'],
                'price' => $t['price'],
                'category' => $t['category'],
                'status' => 'Active',
                'lab_id' => $lab->id,
                'parameters' => ['Hemoglobin', 'WBC Count', 'Platelet Count']
            ]);
        }

        // 4. Create Patients & Bookings
        $patientsData = [
            ['name' => 'John Doe', 'phone' => '9876543210', 'dr' => 'Dr. Smith'],
            ['name' => 'Jane Watson', 'phone' => '8765432109', 'dr' => 'Dr. House'],
            ['name' => 'Robert Miller', 'phone' => '7654321098', 'dr' => 'Dr. Wilson'],
            ['name' => 'Sarah Connor', 'phone' => '6543210987', 'dr' => 'Self'],
        ];

        foreach ($patientsData as $index => $pData) {
            $patient = Patient::create([
                'name' => $pData['name'],
                'age' => rand(20, 60),
                'gender' => rand(0, 1) ? 'Male' : 'Female',
                'phone' => $pData['phone'],
                'address' => 'Sample Address, Block ' . $index,
                'reference_dr_name' => $pData['dr'],
                'visit_date' => Carbon::now()->subDays(rand(1, 10)),
                'lab_id' => $lab->id
            ]);

            $total = rand(1000, 3000);
            $discount = rand(100, 500);
            $advance = rand(500, 1000);
            $balance = $total - $discount - $advance;

            $booking = Booking::create([
                'booking_id' => 'BKG-00' . ($index + 1),
                'bill_no' => 'BILL-X' . (1000 + $index),
                'patient_id' => $patient->id,
                'lab_id' => $lab->id,
                'tests' => [1, 2], // IDs of tests
                'booking_date' => $patient->visit_date,
                'booking_time' => Carbon::now()->format('H:i:s'),
                'amount' => $total - $discount,
                'total_amount' => $total - $discount,
                'discount' => $discount,
                'advance_amount' => $advance,
                'balance_amount' => $balance,
                'status' => $index % 2 == 0 ? 'Confirmed' : 'Pending'
            ]);

            if ($booking->status == 'Confirmed') {
                Report::create([
                    'booking_id' => $booking->id,
                    'lab_id' => $lab->id,
                    'status' => 'Completed'
                ]);
            }

            Payment::create([
                'patient_id' => $patient->id,
                'booking_id' => $booking->id,
                'amount' => $advance,
                'payment_status' => 'Paid',
                'payment_method' => 'UPI',
                'transaction_id' => 'TXN' . uniqid()
            ]);
        }
    }
}
