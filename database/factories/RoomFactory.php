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
            'room_name' => $this->faker->unique()->randomElement([
                'Room ' . $this->faker->numberBetween(101, 999),
                'Lab ' . $this->faker->numberBetween(1, 20),
                'Hall ' . $this->faker->numberBetween(1, 5),
            ]),
            'room_type' => $this->faker->randomElement($roomTypes),
            'capacity' => $this->faker->randomElement([30, 40, 50, 60, 80, 100]),
            'building' => $this->faker->randomElement($buildings),
            'floor' => $this->faker->randomElement($floors),
            'status' => $this->faker->randomElement(['available', 'available', 'available', 'occupied', 'maintenance']),
        ];
    }
}