<?php

namespace Database\Factories;

use App\Models\Waiver;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;
use App\Models\Location;
use App\Models\Persona;
use App\Models\Pronoun;

class WaiverFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Waiver::class;

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
            'guest_id' => $this->faker->word,
            'location_id' => $this->faker->word,
            'pronoun_id' => $this->faker->word,
            'persona_id' => $this->faker->word,
            'waiverable_type' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'waiverable_id' => $this->faker->word,
            'file' => $this->faker->text($this->faker->numberBetween(5, 191)),
            'player' => $this->faker->text($this->faker->numberBetween(5, 150)),
            'email' => $this->faker->email,
            'phone' => $this->faker->numerify('0##########'),
            'dob' => $this->faker->date('Y-m-d'),
            'age_verified_at' => $this->faker->date('Y-m-d'),
            'age_verified_by' => $this->faker->word,
            'guardian' => $this->faker->text($this->faker->numberBetween(5, 150)),
            'emergency_name' => $this->faker->text($this->faker->numberBetween(5, 150)),
            'emergency_relationship' => $this->faker->text($this->faker->numberBetween(5, 150)),
            'emergency_phone' => $this->faker->numerify('0##########'),
            'signed_at' => $this->faker->date('Y-m-d'),
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
            'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
