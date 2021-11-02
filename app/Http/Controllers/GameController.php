<?php

namespace App\Http\Controllers;

use App\Http\Requests\GameMatchStoreRequest;
use App\Http\Requests\GamePostRequest;
use App\Http\Requests\GameStoreRequest;
use App\Http\Requests\PlayerPostRequest;
use App\Repositories\GameMatchRepository;
use App\Repositories\GameRepository;
use App\Repositories\PlayerRepository;
use Exception;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Throwable;

class GameController extends Controller
{
    /**
     * @var DatabaseManager
     */
    protected DatabaseManager $db;

    /**
     * @var GameRepository
     */
    protected GameRepository $gameRepository;

    /**
     * @var PlayerRepository
     */
    protected PlayerRepository $playerRepository;

    /**
     * @var GameMatchRepository
     */
    protected GameMatchRepository $gameMatchRepository;

    /**
     * @param DatabaseManager $db
     * @param GameRepository $gameRepository
     * @param PlayerRepository $playerRepository
     */
    public function __construct(
        DatabaseManager $db,
        GameRepository $gameRepository,
        PlayerRepository $playerRepository,
        GameMatchRepository $gameMatchRepository
    )
    {
        $this->db                  = $db;
        $this->gameRepository      = $gameRepository;
        $this->playerRepository    = $playerRepository;
        $this->gameMatchRepository = $gameMatchRepository;
    }

    private function createPlayers(string $playerOneNickname, string $playerTwoNickname): Collection
    {
        $requestPlayerOne = new PlayerPostRequest(['nickname' => $playerOneNickname]);
        $playerOne = $this->playerRepository->createPlayer($requestPlayerOne);

        $requestPlayerTwo = new PlayerPostRequest(['nickname' => $playerTwoNickname]);
        $playerTwo = $this->playerRepository->createPlayer($requestPlayerTwo);

        return collect([
            1 => $playerOne->toArray(),
            2 => $playerTwo->toArray()
        ]);
    }

    private function createGameRequest(GamePostRequest $request, Collection $players): GameStoreRequest
    {
        $playersById    = $players->keyBy('id')->toArray();
        $playerX        = array_search(
            $request->get('player_x_nickname'),
            array_column($playersById, 'nickname', 'id')
        );
        $playerO        = array_search(
            $request->get('player_o_nickname'),
            array_column($playersById, 'nickname', 'id')
        );

        return new GameStoreRequest([
            'player_one_id'      => $players->get(1)['id'],
            'player_two_id'      => $players->get(2)['id'],
            'player_id_symbol_x' => $playerX,
            'player_id_symbol_o' => $playerO,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param GamePostRequest $request
     * @return RedirectResponse
     * @throws Throwable
     */
    public function store(GamePostRequest $request): RedirectResponse
    {
        try {
            $this->db->beginTransaction();

            $players     = $this->createPlayers(
                $request->get('player_one_nickname'),
                $request->get('player_two_nickname'),
            );

            $gameRequest = $this->createGameRequest($request, $players);
            $game        = $this->gameRepository->createGame($gameRequest);

            if (is_null($game)) {
                throw new Exception('game not created, please, try again soon.', '500');
            }

            $gameMatch   = $this->gameMatchRepository->createGameMatch(new GameMatchStoreRequest([
                'game_id' => $game->getAttribute('id')
            ]));

            if (is_null($gameMatch)) {
                throw new Exception('game match not created, please, try again soon.', '500');
            }

//            $this->db->commit();

            session()->put('game', $game);
            session()->put('currentGameMatch', $gameMatch);

            $this->db->rollBack();
        } catch (Throwable $e) {
            $this->db->rollBack();

            throw $e;
        }

        return redirect()->route('game.show');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('game')->withErrors(null);
    }
}
