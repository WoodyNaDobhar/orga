<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        return [
            'park_id' => $this->faker->word,
            'pronoun_id' => $this->faker->word,
            'name' => $this->faker->text($this->faker->numberBetween(5, 255)),
            'persona' => $this->faker->text($this->faker->numberBetween(5, 255)),
            'heraldry' => $this->faker->text($this->faker->numberBetween(5, 255)),
            'image' => $this->faker->text($this->faker->numberBetween(5, 255)),
            'email' => $this->faker->email,
            'email_verified_at' => $this->faker->date('Y-m-d H:i:s'),
            'password' => $this->faker->lexify('1???@???A???'),
            'remember_token' => $this->faker->text($this->faker->numberBetween(5, 100)),
            'restricted' => $this->faker->boolean,
            'waivered' => $this->faker->boolean,
            'waiver_ext' => $this->faker->text($this->faker->numberBetween(5, 8)),
            'penalty_box' => $this->faker->boolean,
            'is_active' => $this->faker->boolean,
            'reeve_qualified_expires' => $this->faker->date('Y-m-d'),
            'corpora_qualified_expires' => $this->faker->date('Y-m-d'),
            'joined_park_at' => $this->faker->date('Y-m-d'),
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
            'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
