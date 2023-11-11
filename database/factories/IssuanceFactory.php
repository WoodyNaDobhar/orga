<?php

namespace Database\Factories;

use App\Models\Issuance;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Persona;
use App\Models\User;

class IssuanceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Issuance::class;

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
            'issuable_type' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'issuable_id' => $this->faker->word,
            'whereable_type' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'whereable_id' => $this->faker->word,
            'authority_type' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'authority_id' => $this->faker->word,
            'recipient_type' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'recipient_id' => $this->faker->word,
            'issuer_id' => $this->faker->word,
            'custom_name' => $this->faker->text($this->faker->numberBetween(5, 64)),
            'rank' => $this->faker->word,
            'issued_at' => $this->faker->date('Y-m-d'),
            'note' => $this->faker->text($this->faker->numberBetween(5, 400)),
            'image' => $this->faker->text($this->faker->numberBetween(5, 255)),
            'revoked_by' => $this->faker->word,
            'revoked_at' => $this->faker->date('Y-m-d'),
            'revocation' => $this->faker->text($this->faker->numberBetween(5, 50)),
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
            'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
