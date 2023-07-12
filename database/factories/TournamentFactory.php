<?php

namespace Database\Factories;

use App\Models\Tournament;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;

class TournamentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tournament::class;

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
            'tournamentable_type' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'tournamentable_id' => $this->faker->word,
            'event_id' => $this->faker->word,
            'name' => $this->faker->text($this->faker->numberBetween(5, 50)),
            'description' => $this->faker->text($this->faker->numberBetween(5, 16777215)),
            'url' => $this->faker->text($this->faker->numberBetween(5, 255)),
            'occured_at' => $this->faker->date('Y-m-d H:i:s'),
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
            'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
