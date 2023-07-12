<?php

namespace Database\Factories;

use App\Models\KingdomTitle;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;
use App\Models\Kingdom;
use App\Models\Kingdom;
use App\Models\User;

class KingdomTitleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = KingdomTitle::class;

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
            'kingdom_id' => $this->faker->word,
            'title_id' => $this->faker->word,
            'custom_name' => $this->faker->text($this->faker->numberBetween(5, 100)),
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
            'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
