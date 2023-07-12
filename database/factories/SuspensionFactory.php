<?php

namespace Database\Factories;

use App\Models\Suspension;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;

class SuspensionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Suspension::class;

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
            'id' => $this->faker->word,
            'user_id' => $this->faker->word,
            'suspended_by' => $this->faker->word,
            'suspended_at' => $this->faker->date('Y-m-d'),
            'suspended_expires' => $this->faker->date('Y-m-d'),
            'cause' => $this->faker->text($this->faker->numberBetween(5, 255)),
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
            'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
