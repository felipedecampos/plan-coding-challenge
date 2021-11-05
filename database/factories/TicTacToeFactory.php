<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\TicTacToe;
use App\Models\PlayHistory;
use App\TicTacToe\Board;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class TicTacToeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TicTacToe::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $board       = Board::factory()->makeOne();
        $playHistory = PlayHistory::factory()->makeOne(['id' => $this->faker->numerify('######')]);

        $playerSymbolOne = "X";
        $playerSymbolTwo = "O";
        $players   = Arr::shuffle([$playerSymbolOne, $playerSymbolTwo]);

        $matchEnds    = $this->faker->randomElement([true, false]);
        $matchTied    = $this->faker->randomElement([true, false]);
        $playerWinner = "";
        $playerLoser  = "";

        if ($matchEnds && !$matchTied) {
            $playerWinner = Arr::first($players);
            $playerLoser  = Arr::last($players);
        }

        return [
            'board_id'                      => $board->getAttribute('id'),
            'player_symbol_one'             => Arr::first($players),
            'player_symbol_two'             => Arr::last($players),
            'play_history_id'               => $playHistory->getAttribute('id'),
            'winner'                        => $playerWinner,
            'loser'                         => $playerLoser,
            'tied'                          => $matchTied,
            'ends'                          => $matchEnds,
            'current_play_order'            => $this->faker->randomNumber(),
            'player_symbol_starts'          => Arr::first($players),
            'player_symbol_allowed_to_play' => Arr::last($players),
            'created_at'                    => now(),
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
