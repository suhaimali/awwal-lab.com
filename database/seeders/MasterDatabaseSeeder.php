<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lab;
use App\Models\TestCategory;
use App\Models\TestType;
use App\Models\TestParameter;
use App\Models\Patient;
use App\Models\Booking;
use App\Models\Report;
use App\Models\ReportItem;
use App\Models\Payment;
use App\Models\Equipment;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MasterDatabaseSeeder extends Seeder
{
    public function run()
    {
        // 0. Cleanup
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Task::truncate();
        Equipment::truncate();
        Payment::truncate();
        ReportItem::truncate();
        Report::truncate();
        Booking::truncate();
        Patient::truncate();
        TestType::truncate();
        TestParameter::truncate();
        TestCategory::truncate();
        Lab::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 1. Users
        User::firstOrCreate(
            ['email' => 'admin@suhaim.com'],
            ['name' => 'Admin User', 'password' => bcrypt('password'), 'role' => 'admin']
        );
        User::firstOrCreate(
            ['email' => 'staff@suhaim.com'],
            ['name' => 'Staff User', 'password' => bcrypt('password'), 'role' => 'staff']
        );

        // 2. Facilities (Labs)
        $labs = [
            ['lab_name' => 'Suhaim Soft Laboratory', 'description' => 'Main Diagnostic Node'],
            ['lab_name' => 'City Scan Center', 'description' => 'Radiology Specialized Unit'],
        ];
        foreach ($labs as $l) Lab::create($l);
        $mainLab = Lab::first();

        // 2. Clinical Infrastructure (Equipment)
        $equipment = [
            ['name' => 'Hematology Analyzer H50', 'lab_id' => $mainLab->id, 'status' => 'Operational'],
            ['name' => 'Biochemistry System B200', 'lab_id' => $mainLab->id, 'status' => 'Operational'],
            ['name' => 'Immunoassay Module I30', 'lab_id' => $mainLab->id, 'status' => 'Available'],
            ['name' => 'Centrifuge High-Speed', 'lab_id' => $mainLab->id, 'status' => 'Maintenance'],
        ];
        foreach ($equipment as $e) Equipment::create($e);

        // 3. Clinical Parameters
        $params = [
            ['name' => 'Hemoglobin', 'unit' => 'g/dL', 'normal_range' => '13.5-17.5'],
            ['name' => 'WBC Count', 'unit' => 'cells/mcL', 'normal_range' => '4500-11000'],
            ['name' => 'Platelet Count', 'unit' => 'cells/mcL', 'normal_range' => '150000-450000'],
            ['name' => 'Glucose (Random)', 'unit' => 'mg/dL', 'normal_range' => '70-140'],
            ['name' => 'Bilirubin Total', 'unit' => 'mg/dL', 'normal_range' => '0.1-1.2'],
        ];
        foreach ($params as $p) TestParameter::create($p);

        // 4. Test Categories & Types
        $categories = ['Hematology', 'Biochemistry', 'Serology'];
        foreach ($categories as $cat) TestCategory::create(['name' => $cat]);

        $testTypes = [
            ['test_code' => 'CBC01', 'name' => 'Complete Blood Count', 'price' => 500, 'category' => 'Hematology', 'params' => ['Hemoglobin', 'WBC Count', 'Platelet Count']],
            ['test_code' => 'LFT02', 'name' => 'Liver Function Test', 'price' => 1200, 'category' => 'Biochemistry', 'params' => ['Bilirubin Total']],
            ['test_code' => 'GLU03', 'name' => 'Glucose Profiling', 'price' => 300, 'category' => 'Biochemistry', 'params' => ['Glucose (Random)']],
        ];

        foreach ($testTypes as $t) {
            TestType::create([
                'test_code' => $t['test_code'],
                'name' => $t['name'],
                'price' => $t['price'],
                'category' => $t['category'],
                'status' => 'Active',
                'parameters' => $t['params']
            ]);
        }

        // 5. Clinical Operations (Patients, Bookings, Reports, Payments)
        $patientsData = [
            ['name' => 'John Doe', 'phone' => '9876543210', 'dr' => 'Dr. Smith'],
            ['name' => 'Jane Watson', 'phone' => '8765432109', 'dr' => 'Dr. House'],
            ['name' => 'Robert Miller', 'phone' => '7654321098', 'dr' => 'Dr. Wilson'],
            ['name' => 'Sarah Connor', 'phone' => '6543210987', 'dr' => 'Self'],
        ];

        foreach ($patientsData as $index => $pData) {
            $patient = Patient::create([
                'name' => $pData['name'],
                'age' => rand(20, 70),
                'gender' => $index % 2 == 0 ? 'Male' : 'Female',
                'phone' => $pData['phone'],
                'address' => 'Protocol Street, Node ' . ($index + 1),
                'reference_dr_name' => $pData['dr'],
                'visit_date' => Carbon::now()->subDays(rand(1, 5)),
            ]);

            $total = rand(1500, 5000);
            $discount = rand(100, 500);
            $advance = rand(500, 1000);
            $balance = $total - $discount - $advance;

            $booking = Booking::create([
                'booking_id' => 'BKG-' . strtoupper(uniqid()),
                'bill_no' => 'BILL-X' . (1000 + $index),
                'patient_id' => $patient->id,
                'lab_id' => $mainLab->id,
                'tests' => [1, 2],
                'booking_date' => $patient->visit_date,
                'booking_time' => '09:00:00',
                'amount' => $total - $discount,
                'total_amount' => $total - $discount,
                'discount' => $discount,
                'advance_amount' => $advance,
                'balance_amount' => $balance,
                'status' => 'Confirmed'
            ]);

            $report = Report::create([
                'booking_id' => $booking->id,
                'lab_id' => $mainLab->id,
                'status' => $index % 2 == 0 ? 'Completed' : 'Pending'
            ]);

            // Populate report items from tests
            $testIds = $booking->tests ?: [];
            foreach ($testIds as $testId) {
                $testType = TestType::find($testId);
                if ($testType && is_array($testType->parameters)) {
                    foreach ($testType->parameters as $paramName) {
                        $paramDetail = TestParameter::where('name', $paramName)->first();
                        ReportItem::create([
                            'report_id' => $report->id,
                            'test_type_id' => $testType->id,
                            'parameter_name' => $paramName,
                            'category' => $paramDetail?->category,
                            'normal_range' => $paramDetail?->normal_range,
                            'unit' => $paramDetail?->unit,
                            'result_value' => $index % 2 == 0 ? (string)rand(50, 200) : null,
                        ]);
                    }
                }
            }

            Payment::create([
                'patient_id' => $patient->id,
                'booking_id' => $booking->id,
                'amount' => $advance,
                'payment_status' => 'Paid',
                'payment_method' => 'Cash',
            ]);
        }

        // 6. Operational Tasks
        $admin = User::where('role', 'admin')->first();
        Task::create([
            'title' => 'Equipment Calibration: Centrifuge',
            'description' => 'Perform monthly maintenance and speed calibration for the main centrifuge unit.',
            'status' => 'Pending',
            'assigned_to' => $admin?->id
        ]);
        Task::create([
            'title' => 'Diagnostic Protocol Review',
            'description' => 'Verify new clinical parameters for Hematology module.',
            'status' => 'In Progress',
            'assigned_to' => $admin?->id
        ]);
    }
}
