<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patient;
use App\Models\Booking;
use App\Models\Report;
use App\Models\ReportItem;
use App\Models\TestType;
use App\Models\Lab;
use Illuminate\Support\Facades\DB;

class DiagnosticSeeder extends Seeder
{
    public function run(): void
    {
        $lab = Lab::first();
        if (!$lab) {
            $lab = Lab::create([
                'name' => 'Suhaim Soft Lab Main',
                'address' => 'Protocol Street, Healthcare Zone',
                'phone' => '+91 9988776655',
                'email' => 'core@suhaimsoft.com',
                'status' => 'Active'
            ]);
        }

        // 1. Create Test Types if none exist
        if (TestType::count() == 0) {
            TestType::create([
                'test_code' => 'CBC-001',
                'name' => 'Complete Blood Count',
                'category' => 'Hematology',
                'price' => 500,
                'parameters' => ['Hemoglobin', 'WBC Count', 'Platelet Count'],
                'status' => 'Active',
                'lab_id' => $lab->id
            ]);
            TestType::create([
                'test_code' => 'LIVER-002',
                'name' => 'Liver Function Test',
                'category' => 'Biochemistry',
                'price' => 1200,
                'parameters' => ['SGOT', 'SGPT', 'Bilirubin'],
                'status' => 'Active',
                'lab_id' => $lab->id
            ]);
        }

        $tests = TestType::all();

        // 2. Create Patients
        $patients = [
            ['name' => 'John Wick', 'phone' => '1112223334', 'gender' => 'Male', 'age' => 45, 'address' => 'New York', 'visit_date' => now()],
            ['name' => 'Sarah Connor', 'phone' => '5556667778', 'gender' => 'Female', 'age' => 38, 'address' => 'Los Angeles', 'visit_date' => now()],
            ['name' => 'Thomas Anderson', 'phone' => '9990001112', 'gender' => 'Male', 'age' => 32, 'address' => 'Matrix City', 'visit_date' => now()],
        ];

        foreach ($patients as $pData) {
            $patient = Patient::create(array_merge($pData, ['lab_id' => $lab->id]));

            // 3. Create Bookings
            $booking = Booking::create([
                'bill_no' => 'BILL-' . rand(10000, 99999),
                'booking_id' => 'BKG-' . rand(1000, 9999),
                'patient_id' => $patient->id,
                'tests' => $tests->pluck('id')->toArray(),
                'booking_date' => now(),
                'total_amount' => $tests->sum('price'),
                'status' => 'Confirmed',
                'lab_id' => $lab->id,
                'reporting_date' => now()->addDay(),
                'advance_amount' => 0,
                'balance_amount' => $tests->sum('price'),
                'discount' => 0,
            ]);

            // 4. Create Reports
            $report = Report::create([
                'lab_id' => $lab->id,
                'booking_id' => $booking->id,
                'status' => rand(0, 1) ? 'Completed' : 'Pending',
            ]);

            // 5. Create Report Items
            foreach ($tests as $test) {
                if (is_array($test->parameters)) {
                    foreach ($test->parameters as $param) {
                        ReportItem::create([
                            'report_id' => $report->id,
                            'test_type_id' => $test->id,
                            'parameter_name' => $param,
                            'category' => $test->category,
                            'result_value' => rand(10, 100),
                            'normal_range' => '10-150',
                            'unit' => 'unit',
                        ]);
                    }
                }
            }
        }
    }
}
