<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\GameHistory;
use App\TicTacToe\Game;
use Exception;
use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class GameHistoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GameHistory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws Exception
     */
    public function definition()
    {
        $faker = Faker::create();

        return [
            'session_id' => Str::random(32),
            'game'       => new Game($faker->firstName(), $faker->firstName()),
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
