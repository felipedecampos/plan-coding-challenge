<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\GameMatch;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class GameMatchFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GameMatch::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $playerOne    = $this->faker->numerify('######');
        $playerTwo    = $this->faker->numerify('######');
        $players      = Arr::shuffle([$playerOne, $playerTwo]);
        $matchEnds    = $this->faker->randomElement([true, false]);
        $playerWinner = null;
        $playerLoser  = null;

        if ($matchEnds) {
            $playerWinner = Arr::first($players);
            $playerLoser  = Arr::last($players);
        }

        return [
            'game_id'          => $this->faker->numerify('######'),
            'player_id_starts' => $this->faker->randomElement($players),
            'winner_player_id' => $playerWinner,
            'loser_player_id'  => $playerLoser,
            'match_ends'       => $matchEnds,
            'created_at'       => now(),
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
