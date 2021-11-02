<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Http\Requests\PlayerPostRequest;
use App\Models\Player;

class PlayerRepository extends BaseRepository
{
    /**
     * @var string
     */
    protected string $modelClass = Player::class;

    /**
     * @param PlayerPostRequest $request
     * @return Player
     */
    public function createPlayer(PlayerPostRequest $request): Player
    {
        return $this->newQuery()->firstOrCreate($request->toArray());
    }
}
