<?php

namespace Database\Factories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;

class LocationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Location::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        $user = User::first();
        if (!$user) {
            $user = User::factory()->create();
        }

        return [
            'address' => $this->faker->text($this->faker->numberBetween(5, 255)),
            'city' => $this->faker->text($this->faker->numberBetween(5, 50)),
            'province' => $this->faker->text($this->faker->numberBetween(5, 35)),
            'postal_code' => $this->faker->text($this->faker->numberBetween(5, 10)),
            'country' => $this->faker->lexify('?????'),
            'google_geocode' => $this->faker->text($this->faker->numberBetween(5, 16777215)),
            'latitude' => $this->faker->numberBetween(0, 9223372036854775807),
            'longitude' => $this->faker->numberBetween(0, 9223372036854775807),
            'location' => $this->faker->text($this->faker->numberBetween(5, 16777215)),
            'map_url' => $this->faker->text($this->faker->numberBetween(5, 16777215)),
            'description' => $this->faker->text($this->faker->numberBetween(5, 16777215)),
            'directions' => $this->faker->text($this->faker->numberBetween(5, 16777215)),
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
            'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
