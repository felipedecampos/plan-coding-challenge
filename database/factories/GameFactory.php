<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Game;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class GameFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Game::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $playerOne = $this->faker->numerify('######');
        $playerTwo = $this->faker->numerify('######');
        $players   = Arr::shuffle([$playerOne, $playerTwo]);

        return [
            'player_one_id'      => $playerOne,
            'player_two_id'      => $playerTwo,
            'player_id_symbol_x' => Arr::first($players),
            'player_id_symbol_o' => Arr::last($players),
            'created_at'         => now(),
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
