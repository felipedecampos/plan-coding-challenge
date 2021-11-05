<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Play;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class PlayFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Play::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $positions = [
            'top-left',
            'top-middle',
            'top-right',
            'middle-left',
            'middle-middle',
            'middle-right',
            'bottom-left',
            'bottom-middle',
            'bottom-right'
        ];

        return [
            'match_id'   => $this->faker->numerify('######'),
            'player_id'  => $this->faker->numerify('######'),
            'position'   => $this->faker->randomElement($positions),
            'play'       => $this->faker->randomDigitNot(0),
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
