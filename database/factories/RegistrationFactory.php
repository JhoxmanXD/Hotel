<?php

namespace Database\Factories;

use App\Models\Registration;
use App\Models\Employee;
use App\Models\Room;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class RegistrationFactory extends Factory
{
    protected $model = Registration::class;

    public function definition(): array
    {
        $employeeId = Employee::count()
            ? Employee::inRandomOrder()->first()->id
            : Employee::factory()->create()->id;

        $roomId = Room::count()
            ? Room::inRandomOrder()->first()->id
            : Room::factory()->create()->id;

        $clientId = Client::count()
            ? Client::inRandomOrder()->first()->id
            : Client::factory()->create()->id;

        $checkinDt = $this->faker->dateTimeBetween('-1 month', 'now');
        $checkoutDt = (clone $checkinDt);
        $checkoutDt->modify('+'.rand(1,7).' days');

        $checkinDate = $checkinDt->format('Y-m-d');
        $checkoutDate = $checkoutDt->format('Y-m-d');

        $checkinTime = $this->faker->dateTimeBetween($checkinDt, $checkoutDt)->format('Y-m-d H:i:s');
        $checkoutTime = $this->faker->dateTimeBetween($checkinDt, $checkoutDt)->format('Y-m-d H:i:s');

        return [
            'employee_id'   => $employeeId,
            'room_id'       => $roomId,
            'client_id'     => $clientId,
            'checkindate'   => $checkinDate,
            'checkoutdate'  => $checkoutDate,
            'checkintime'   => $checkinTime,
            'checkouttime'  => $checkoutTime,
        ];
    }
}