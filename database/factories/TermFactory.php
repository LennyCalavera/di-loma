<?php

namespace Database\Factories;

use App\Models\Term;
use Illuminate\Database\Eloquent\Factories\Factory;

class TermFactory extends Factory
{
	/**
	 * The name of the factory's corresponding model.
	 * @var string
	 */
	protected $model = Term::class;

	/**
	 * Define the model's default state.
	 * @return array
	 */
	public function definition()
	{
		return [
			'name' => $this->faker->word,
			'minBorder' => $this->faker->randomDigitNotNull,
			'maxBorder' => $this->faker->randomDigitNotNull,
			'created_at' => $this->faker->date('Y-m-d H:i:s'),
			'updated_at' => $this->faker->date('Y-m-d H:i:s')
		];
	}
}
