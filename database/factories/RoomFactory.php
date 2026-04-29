<?php

namespace Database\Factories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Room>
 */
class RoomFactory extends Factory
{
    protected $model = Room::class;

    public function definition(): array
    {
        $buildings = ['Main Building', 'Science Building', 'Arts Building', 'Admin Building', 'Gymnasium'];
        $roomTypes = ['Classroom', 'Laboratory', 'Office', 'Auditorium', 'Conference Room'];
        $floors = [1, 2, 3, 4, 5];

        return [
            'room_name' => fake()->unique()->randomElement([
                'Room ' . fake()->numberBetween(101, 999),
                'Lab ' . fake()->numberBetween(1, 20),
                'Hall ' . fake()->numberBetween(1, 5),
            ]),
            'room_type' => fake()->randomElement($roomTypes),
            'capacity' => fake()->randomElement([30, 40, 50, 60, 80, 100]),
            'building' => fake()->randomElement($buildings),
            'floor' => fake()->randomElement($floors),
            'status' => fake()->randomElement(['available', 'available', 'available', 'occupied', 'maintenance']),
        ];
    }
}