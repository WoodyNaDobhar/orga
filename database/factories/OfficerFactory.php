<?php

namespace Database\Factories;

use App\Models\Officer;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;
use App\Models\Office;
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
            'office_id' => $this->faker->word,
            'user_id' => $this->faker->word,
            'authorized_by' => $this->faker->word,
            'officerable_type' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'officerable_id' => $this->faker->word,
            'scope' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
            'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
