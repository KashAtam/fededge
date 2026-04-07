<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['car', 'truck', 'bus', 'motorcycle', 'trailer'];
        $brands = ['Toyota', 'Honda', 'Mercedes', 'BMW', 'Audi', 'Ford', 'Chevrolet', 'Nissan'];

        return [
            'plate_number' => strtoupper($this->faker->unique()->bothify('??-###-??')),
            'vehicle_type' => $this->faker->randomElement($types),
            'brand_model' => $this->faker->randomElement($brands).' '.$this->faker->word(),
            'year_of_manufacture' => $this->faker->numberBetween(2015, now()->year),
            'vin' => strtoupper($this->faker->unique()->bothify('?????##########')),
            'engine_number' => strtoupper($this->faker->unique()->bothify('ENG-########')),
            'color' => $this->faker->safeColorName(),
            'engine_capacity' => $this->faker->randomElement([1.0, 1.2, 1.5, 1.6, 1.8, 2.0, 2.5, 3.0]),
            'owner_id' => User::factory()->vehicleOwner(),
            'status' => 'active',
        ];
    }
}
