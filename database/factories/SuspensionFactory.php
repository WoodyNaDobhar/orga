<?php

namespace Database\Factories;

use App\Models\Suspension;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Realm;
use App\Models\Persona;
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
            'persona_id' => $this->faker->word,
            'realm_id' => $this->faker->word,
            'suspended_by' => $this->faker->word,
            'suspended_at' => $this->faker->date('Y-m-d'),
            'expires_at' => $this->faker->date('Y-m-d'),
            'cause' => $this->faker->text($this->faker->numberBetween(5, 191)),
            'is_propogating' => $this->faker->boolean,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
            'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
