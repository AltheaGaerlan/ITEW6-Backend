<?php

namespace Database\Factories;

use Faker\Factory as FakerFactory;
use App\Models\Room;

/**
 * @extends Factory<Room>
 */
class RoomFactory extends Factory
{
    protected $model = Room::class;

    public function definition(): array
    {
        $faker = FakerFactory::create();
        $buildings = ['Main Building', 'Science Building', 'Arts Building', 'Admin Building', 'Gymnasium'];
        $roomTypes = ['Classroom', 'Laboratory', 'Office', 'Auditorium', 'Conference Room'];
        $floors = [1, 2, 3, 4, 5];

        return [
            'room_name' => $faker->unique()->randomElement([
                'Room ' . $faker->numberBetween(101, 999),
                'Lab ' . $faker->numberBetween(1, 20),
                'Hall ' . $faker->numberBetween(1, 5),
            ]),
            'room_type' => $faker->randomElement($roomTypes),
            'capacity' => $faker->randomElement([30, 40, 50, 60, 80, 100]),
            'building' => $faker->randomElement($buildings),
            'floor' => $faker->randomElement($floors),
            'status' => $faker->randomElement(['available', 'available', 'available', 'occupied', 'maintenance']),
        ];
    }
}