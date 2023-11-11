<?php

namespace Database\Factories;

use App\Models\Officer;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Office;
use App\Models\Persona;
use App\Models\User;

class OfficerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Officer::class;

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
            'officeable_type' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'officeable_id' => $this->faker->word,
            'office_id' => $this->faker->word,
            'persona_id' => $this->faker->word,
            'authorized_by' => $this->faker->word,
            'label' => $this->faker->text($this->faker->numberBetween(5, 50)),
            'starts_on' => $this->faker->date('Y-m-d'),
            'ends_on' => $this->faker->date('Y-m-d'),
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
            'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
