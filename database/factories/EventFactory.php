<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;
use App\Models\Location;

class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Event::class;

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
            'eventable_type' => $this->faker->text($this->faker->numberBetween(5, 4096)),
        	'eventable_id' => $this->faker->word,
        	'sponsorable_type' => $this->faker->text($this->faker->numberBetween(5, 4096)),
        	'sponsorable_id' => $this->faker->word,
            'location_id' => $this->faker->word,
            'name' => $this->faker->text($this->faker->numberBetween(5, 191)),
            'description' => $this->faker->text($this->faker->numberBetween(5, 16777215)),
            'image' => $this->faker->text($this->faker->numberBetween(5, 255)),
            'is_active' => $this->faker->boolean,
            'is_demo' => $this->faker->boolean,
            'event_started_at' => $this->faker->date('Y-m-d H:i:s'),
            'event_ended_at' => $this->faker->date('Y-m-d H:i:s'),
            'price' => $this->faker->numberBetween(0, 9223372036854775807),
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
            'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
