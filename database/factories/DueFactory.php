<?php

namespace Database\Factories;

use App\Models\Due;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;
use App\Models\Park;
use App\Models\User;
use App\Models\Transaction;
use App\Models\User;

class DueFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Due::class;

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
            'user_id' => $this->faker->word,
            'park_id' => $this->faker->word,
            'transaction_id' => $this->faker->word,
            'is_for_life' => $this->faker->boolean,
            'dues_at' => $this->faker->date('Y-m-d'),
            'intervals' => $this->faker->word,
            'revoked_on' => $this->faker->date('Y-m-d'),
            'revoked_by' => $this->faker->word,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
            'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
