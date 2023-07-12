<?php

namespace Database\Factories;

use App\Models\Meetup;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Location;
use App\Models\User;
use App\Models\Location;
use App\Models\Park;
use App\Models\User;

class MeetupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Meetup::class;

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
            'park_id' => $this->faker->word,
            'location_id' => $this->faker->word,
            'alt_location_id' => $this->faker->word,
            'recurrence' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'week_of_month' => $this->faker->word,
            'week_day' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'month_day' => $this->faker->word,
            'occurs_at' => $this->faker->date('H:i:s'),
            'purpose' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'description' => $this->faker->text($this->faker->numberBetween(5, 255)),
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
            'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
