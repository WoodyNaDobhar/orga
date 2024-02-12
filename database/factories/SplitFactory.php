<?php

namespace Database\Factories;

use App\Models\Split;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Account;
use App\Models\User;
use App\Models\Persona;
use App\Models\Transaction;

class SplitFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Split::class;

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
            'account_id' => $this->faker->word,
            'persona_id' => $this->faker->word,
            'transaction_id' => $this->faker->word,
            'amount' => $this->faker->numberBetween(0, 9223372036854775807),
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
            'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
