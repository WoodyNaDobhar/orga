<?php

namespace Database\Factories;

use App\Models\Crat;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;
use App\Models\Event;
use App\Models\Persona;

class CratFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Crat::class;

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
            'event_id' => $this->faker->word,
            'persona_id' => $this->faker->word,
            'role' => $this->faker->text($this->faker->numberBetween(5, 50)),
            'is_autocrat' => $this->faker->boolean,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
            'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
