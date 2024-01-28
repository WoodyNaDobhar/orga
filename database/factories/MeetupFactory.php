<?php

namespace Database\Factories;

use App\Models\Meetup;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Location;
use App\Models\Chapter;
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
            'chapter_id' => $this->faker->word,
            'location_id' => $this->faker->word,
            'is_active' => $this->faker->boolean,
            'purpose' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'recurrence' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'week_of_month' => $this->faker->word,
            'week_day' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'month_day' => $this->faker->word,
            'occurs_at' => $this->faker->date('H:i:s'),
            'description' => $this->faker->text($this->faker->numberBetween(5, 191)),
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
            'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
