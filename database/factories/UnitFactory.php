<?php

namespace Database\Factories;

use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;

class UnitFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Unit::class;

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
            'type' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'name' => $this->faker->text($this->faker->numberBetween(5, 100)),
            'heraldry' => $this->faker->text($this->faker->numberBetween(5, 191)),
            'description' => $this->faker->text($this->faker->numberBetween(5, 16777215)),
            'history' => $this->faker->text($this->faker->numberBetween(5, 16777215)),
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
            'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
