<?php

namespace Database\Factories;

use App\Models\Chaptertype;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;
use App\Models\Realm;

class ChaptertypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Chaptertype::class;

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
            'realm_id' => $this->faker->word,
            'name' => $this->faker->text($this->faker->numberBetween(5, 50)),
            'rank' => $this->faker->word,
            'minimumattendance' => $this->faker->word,
            'minimumcutoff' => $this->faker->word,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
            'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
