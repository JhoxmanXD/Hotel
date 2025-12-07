<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\Registration;
use App\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition(): array
    {
        $registrationId = Registration::count()
            ? Registration::inRandomOrder()->first()->id
            : Registration::factory()->create()->id;

        $paymentMethodId = PaymentMethod::count()
            ? PaymentMethod::inRandomOrder()->first()->id
            : PaymentMethod::factory()->create()->id;

        return [
            'registration_id'    => $registrationId,
            'payment_method_id'  => $paymentMethodId,
            'date'               => $this->faker->date('Y-m-d'),
            'total'              => $this->faker->randomFloat(2, 100, 10000), // 2 decimales, rango 100-10.000
            'state'              => $this->faker->boolean(),
        ];
    }
}