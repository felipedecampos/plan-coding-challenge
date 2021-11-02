<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Http\Requests\GameStoreRequest;
use App\Models\Game;

class GameRepository extends BaseRepository
{
    /**
     * @var string
     */
    protected string $modelClass = Game::class;

    /**
     * @param GameStoreRequest $request
     * @return Game
     */
    public function createGame(GameStoreRequest $request): Game
    {
        return $this->create($request->toArray());
    }
}
