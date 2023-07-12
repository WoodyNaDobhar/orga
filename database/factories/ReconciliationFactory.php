<?php

namespace Database\Factories;

use App\Models\Reconciliation;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Archetype;
use App\Models\User;

class ReconciliationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Reconciliation::class;

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
            'archetype_id' => $this->faker->word,
            'user_id' => $this->faker->word,
            'is_reconciled' => $this->faker->boolean,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
            'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
