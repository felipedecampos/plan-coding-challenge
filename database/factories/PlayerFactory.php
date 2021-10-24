<?php

namespace Database\Factories;

use App\Models\Player;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PlayerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Player::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $randomName = $this->faker->randomElement([
            $this->faker->firstNameFemale(),
            $this->faker->firstNameMale(),
        ]);

        return [
            'nickname'   => Str::lower($randomName),
            'created_at' => now(),
        ];
    }

    /**
     * Indicate that the model's product should be updated.
     *
     * @return Factory
     */
    public function updated(): Factory
    {
        return $this->state(fn(array $attributes) => ['updated_at' => now()]);
    }

    /**
     * Indicate that the model's product should be deleted.
     *
     * @return Factory
     */
    public function deleted(): Factory
    {
        return $this->state(fn(array $attributes) => ['deleted_at' => now()]);
    }
}
