<?php

namespace Database\Factories;

use App\Models\ComprobanteCabeza;
use Illuminate\Database\Eloquent\Factories\Factory;

class ComprobanteCabezaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ComprobanteCabeza::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'codigoComprobante' => $this->faker->creditCardNumber,
            'tipoOperacion' => $this->faker->numberBetween($min = 1, $max = 2),
            'fecha' => $this->faker->dateTime($max = 'now'),
        ];
    }
}
