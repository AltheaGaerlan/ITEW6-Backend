<?php

namespace Database\Factories;

use App\Models\ViolationType;

/**
 * @extends Factory<ViolationType>
 */
class ViolationTypeFactory extends Factory
{
    protected $model = ViolationType::class;

    public function definition(): array
    {
        $types = [
            ['name' => 'Late Attendance', 'severity' => 'Low'],
            ['name' => 'Absence Without Excuse', 'severity' => 'Medium'],
            ['name' => 'Dress Code Violation', 'severity' => 'Low'],
            ['name' => 'Academic Dishonesty', 'severity' => 'High'],
            ['name' => 'Misconduct', 'severity' => 'High'],
        ];

        $picked = $this->faker->unique()->randomElement($types);

        return [
            'violation_name' => $picked['name'],
            'severity_level' => $picked['severity'],
        ];
    }
}