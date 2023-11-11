<?php

namespace Database\Factories;

use App\Models\Recommendation;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;
use App\Models\Persona;

class RecommendationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Recommendation::class;

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
            'persona_id' => $this->faker->word,
            'recommendable_type' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'recommendable_id' => $this->faker->word,
            'rank' => $this->faker->word,
            'is_anonymous' => $this->faker->boolean,
            'reason' => $this->faker->text($this->faker->numberBetween(5, 400)),
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
            'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
