<?php

namespace Database\Factories;

use App\Models\Reign;
use Illuminate\Database\Eloquent\Factories\Factory;


class ReignFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Reign::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        return [
            'reignable_type' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'reignable_id' => $this->faker->word,
            'name' => $this->faker->text($this->faker->numberBetween(5, 100)),
            'starts_on' => $this->faker->date('Y-m-d'),
            'ends_on' => $this->faker->date('Y-m-d'),
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
            'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
