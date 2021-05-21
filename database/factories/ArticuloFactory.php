<?php

namespace Database\Factories;

use App\Models\Articulo;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticuloFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Articulo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombre' => $this->faker->lastName,
            'precio' => $this->faker->numberBetween($min = 30, $max = 1000),
            'fechaVencimiento' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'stockMinimo' => $this->faker->numberBetween($min = 200, $max = 500),
            'stockMaximo' => $this->faker->numberBetween($min = 600, $max = 1000), 
            'rubro_id' => $this->faker->numberBetween($min = 1, $max = 15),
        ];
    }
}
