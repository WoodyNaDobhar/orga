<?php

namespace Database\Factories;

use App\Models\Persona;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Chapter;
use App\Models\User;
use App\Models\Pronoun;

class PersonaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Persona::class;

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
            'chapter_id' => $this->faker->word,
            'user_id' => $this->faker->word,
            'pronoun_id' => $this->faker->word,
            'mundane' => $this->faker->text($this->faker->numberBetween(5, 191)),
            'name' => $this->faker->text($this->faker->numberBetween(5, 191)),
            'heraldry' => $this->faker->text($this->faker->numberBetween(5, 191)),
            'image' => $this->faker->text($this->faker->numberBetween(5, 191)),
            'is_active' => $this->faker->boolean,
            'reeve_qualified_expires_at' => $this->faker->date('Y-m-d'),
            'corpora_qualified_expires_at' => $this->faker->date('Y-m-d'),
            'joined_chapter_at' => $this->faker->date('Y-m-d'),
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
            'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
