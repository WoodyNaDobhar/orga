<?php

namespace Database\Factories;

use App\Models\Guest;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Chapter;
use App\Models\User;
use App\Models\User;
use App\Models\Event;
use App\Models\User;
use App\Models\Waiver;

class GuestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Guest::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        $waiver = Waiver::first();
        if (!$waiver) {
            $waiver = Waiver::factory()->create();
        }

        return [
            'event_id' => $this->faker->word,
            'waiver_id' => $this->faker->word,
            'chapter_id' => $this->faker->word,
            'is_followedup' => $this->faker->boolean,
            'notes' => $this->faker->text($this->faker->numberBetween(5, 191)),
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
            'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
