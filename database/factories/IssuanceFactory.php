<?php

namespace Database\Factories;

use App\Models\Issuance;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'user_id' => $this->faker->word,
            'issuer_id' => $this->faker->word,
            'issuedable_type' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'issuedable_id' => $this->faker->word,
            'custom_name' => $this->faker->text($this->faker->numberBetween(5, 64)),
            'rank' => $this->faker->word,
            'issued_at' => $this->faker->date('Y-m-d'),
            'note' => $this->faker->text($this->faker->numberBetween(5, 400)),
            'image' => $this->faker->imageUrl($width = 640, $height = 480),
            'revocation' => $this->faker->text($this->faker->numberBetween(5, 50)),
            'revoked_by' => $this->faker->word,
            'revoked_at' => $this->faker->date('Y-m-d'),
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
            'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
