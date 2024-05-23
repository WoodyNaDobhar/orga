<?php

namespace Database\Factories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;

class TransactionFactory extends Factory
{
	/**
	 * The name of the factory's corresponding model.
	 *
	 * @var string
	 */
	protected $model = Transaction::class;

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
			'description' => $this->faker->text($this->faker->numberBetween(5, 191)),
			'memo' => $this->faker->text($this->faker->numberBetween(5, 16777215)),
			'transaction_on' => $this->faker->date('Y-m-d'),
			'created_at' => $this->faker->date('Y-m-d H:i:s'),
			'updated_at' => $this->faker->date('Y-m-d H:i:s'),
			'deleted_at' => $this->faker->date('Y-m-d H:i:s')
		];
	}
}
