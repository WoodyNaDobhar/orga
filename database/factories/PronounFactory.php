<?php

namespace Database\Factories;

use App\Models\Pronoun;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;

class PronounFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pronoun::class;

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
            'subject' => $this->faker->text($this->faker->numberBetween(5, 30)),
            'object' => $this->faker->text($this->faker->numberBetween(5, 30)),
            'possessive' => $this->faker->text($this->faker->numberBetween(5, 30)),
            'possessivepronoun' => $this->faker->text($this->faker->numberBetween(5, 30)),
            'reflexive' => $this->faker->text($this->faker->numberBetween(5, 30)),
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
            'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
