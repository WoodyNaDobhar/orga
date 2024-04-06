<?php

namespace Database\Factories;

use App\Models\Persona;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Chapter;
use App\Models\User;
use App\Models\Pronoun;
use App\Models\Issuance;

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
        
        $chapters = Chapter::all()->pluck('id');
        $honorifics = Issuance::all()->pluck('id');
        $pronouns = Pronoun::all()->pluck('id');

        return [
        	'chapter_id' => $this->faker->randomElement($chapters),
        	'honorific_id' => $this->faker->randomElement($honorifics),
        	'pronoun_id' => $this->faker->randomElement($pronouns),
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
