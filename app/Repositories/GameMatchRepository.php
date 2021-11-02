<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Http\Requests\GameMatchStoreRequest;
use App\Models\GameMatch;
use Illuminate\Database\Eloquent\Model;

class GameMatchRepository extends BaseRepository
{
    /**
     * @var string
     */
    protected string $modelClass = GameMatch::class;

    /**
     * @param GameMatchStoreRequest $request
     * @return Model
     */
    public function createGameMatch(GameMatchStoreRequest $request): Model
    {
        return $this->create($request->toArray());
    }
}
