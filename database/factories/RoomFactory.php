<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    protected $model = Room::class;

    public function definition(): array
    {

        $roomTypeId = RoomType::count()
            ? RoomType::inRandomOrder()->first()->id
            : RoomType::factory()->create()->id;

        return [
            'room_type_id' => $roomTypeId, // relación
            'number' => $this->faker->unique()->numerify('###'), 
            'floor' => $this->faker->numberBetween(1, 10),
            'value' => $this->faker->randomFloat(2, 50000, 1000000),
            'numpeople' => $this->faker->numberBetween(1, 6),
        ];
    }
}