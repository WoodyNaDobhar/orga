<?php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;
use App\Models\Persona;
use App\Models\Unit;

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
            'persona_id' => $this->faker->word,
            'unit_id' => $this->faker->word,
            'is_head' => $this->faker->boolean,
            'is_voting' => $this->faker->boolean,
            'joined_at' => $this->faker->date('Y-m-d'),
            'left_at' => $this->faker->date('Y-m-d'),
            'notes' => $this->faker->text($this->faker->numberBetween(5, 191)),
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
            'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
