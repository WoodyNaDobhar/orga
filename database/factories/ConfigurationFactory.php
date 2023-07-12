<?php

namespace Database\Factories;

use App\Models\Configuration;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;

class ConfigurationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Configuration::class;

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
            'configurable_type' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'configurable_id' => $this->faker->word,
            'key' => $this->faker->text($this->faker->numberBetween(5, 50)),
            'value' => $this->faker->text($this->faker->numberBetween(5, 16777215)),
            'is_user_setting' => $this->faker->boolean,
            'allowed_values' => $this->faker->text($this->faker->numberBetween(5, 16777215)),
            'modified' => $this->faker->date('Y-m-d H:i:s'),
            'var_type' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
            'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
