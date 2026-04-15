<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TestType;

class TestTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'CBC', 'category' => 'Blood', 'amount' => 200, 'notes' => 'Complete Blood Count', 'status' => 'Active'],
            ['name' => 'Blood Sugar', 'category' => 'Blood', 'amount' => 100, 'notes' => 'Fasting/PP', 'status' => 'Active'],
            ['name' => 'Lipid Profile', 'category' => 'Blood', 'amount' => 350, 'notes' => 'Cholesterol, Triglycerides', 'status' => 'Active'],
            ['name' => 'Liver Function', 'category' => 'Blood', 'amount' => 400, 'notes' => 'LFT', 'status' => 'Active'],
            ['name' => 'Kidney Function', 'category' => 'Blood', 'amount' => 400, 'notes' => 'KFT', 'status' => 'Active'],
        ];
        foreach ($types as $type) {
            TestType::create($type);
        }
    }
}
