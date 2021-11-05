<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\GameHistory;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class GameHistoryRepository extends BaseRepository
{
    /**
     * @var string
     */
    protected string $modelClass = GameHistory::class;

    /**
     * @param array $fields
     * @return GameHistory|Model
     */
    public function createGame(array $fields): GameHistory|Model
    {
        return $this->create($fields);
    }

    /**
     * Returns all records with `session_id` given.
     * If $take is false then brings all records
     * If $paginate is true returns Paginator instance.
     *
     * @param string $sessionId
     * @param int|bool $take
     * @param bool $paginate
     * @return Paginator|Collection
     */
    public function getGameBySessionId(
        string $sessionId,
        int|bool $take = false,
        bool $paginate = false
    ): Paginator|Collection
    {
        $query = $this->newQuery()->where('session_id', '=', $sessionId)->orderByDesc('id');

        return $this->doQuery($query, $take, $paginate);
    }
}
