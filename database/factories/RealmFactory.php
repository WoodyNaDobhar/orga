<?php

namespace Database\Factories;

use App\Models\Realm;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;

class RealmFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Realm::class;

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
            'parent_id' => $this->faker->word,
            'name' => $this->faker->text($this->faker->numberBetween(5, 100)),
            'abbreviation' => $this->faker->lexify('?????'),
            'color' => $this->faker->text($this->faker->numberBetween(5, 6)),
            'heraldry' => $this->faker->text($this->faker->numberBetween(5, 191)),
            'is_active' => $this->faker->boolean,
            'credit_minimum' => $this->faker->word,
            'credit_maximum' => $this->faker->word,
            'daily_minimum' => $this->faker->word,
            'weekly_minimum' => $this->faker->word,
            'average_period_type' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'average_period' => $this->faker->word,
            'dues_amount' => $this->faker->word,
            'dues_intervals_type' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'dues_intervals' => $this->faker->word,
        	'dues_take' => $this->faker->number,
        	'waiver_duration' => $this->faker->number,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
            'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
