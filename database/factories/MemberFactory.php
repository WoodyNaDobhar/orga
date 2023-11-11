<?php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;
use App\Models\Persona;

class MemberFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Member::class;

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
            'unit_id' => $this->faker->word,
            'persona_id' => $this->faker->word,
            'role' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'joined_at' => $this->faker->date('Y-m-d'),
            'left_at' => $this->faker->date('Y-m-d'),
            'notes' => $this->faker->text($this->faker->numberBetween(5, 191)),
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
            'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
