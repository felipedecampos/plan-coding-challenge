<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\GameStoreRequest;
use App\TicTacToe\Game;
use App\TicTacToe\Play;
use App\TicTacToe\SetUp;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Throwable;

class TicTacToeController extends Controller
{
    /**
     * @var DatabaseManager
     */
    protected DatabaseManager $db;

    /**
     * @param DatabaseManager $db
     */
    public function __construct(DatabaseManager $db)
    {
        $this->db = $db;
    }

    /**
     * @param string $playerSymbolOne
     * @param string $playerSymbolTwo
     * @return void
     * @throws Exception
     */
    private function initGame(string $playerSymbolOne, string $playerSymbolTwo): void
    {
        $game = new Game($playerSymbolOne, $playerSymbolTwo);

        session()->put('game', $game);
        session()->put('player_symbol_one', $playerSymbolOne);
        session()->put('player_symbol_two', $playerSymbolTwo);

    }

    /**
     * @return void
     * @throws Exception
     */
    private function restartGame(): void
    {
        if (! session()->has('player_symbol_one') || ! session()->has('player_symbol_two'))
        {
            throw new Exception('player symbols not found to restart the game.');
        }

        $this->initGame(session()->get('player_symbol_one'), session()->get('player_symbol_two'));
    }

    /**
     * @return bool
     */
    private function hasGame(): bool
    {
        return session()->has('game');
    }

    /**
     * @return Game
     * @throws Exception
     */
    private function getCurrentGame(): Game
    {
        if (! $this->hasGame())
        {
            throw new Exception('game not found');
        }

        return session()->get('game');
    }

    /**
     * @return void
     */
    private function endCurrentGame(): void
    {
        session()->forget('game');
    }

    /**
     * @return void
     */
    private function destroyGame(): void
    {
        session()->flush();
    }

    /**
     * @return RedirectResponse|View
     * @throws Throwable
     */
    public function index(): RedirectResponse|View
    {
        if ($this->hasGame()) {
            return redirect()->route('tictactoe.board');
        }

        return view('index')->with([
            'playerSymbolOne' => SetUp::PLAYER_SYMBOL_ONE,
            'playerSymbolTwo' => SetUp::PLAYER_SYMBOL_TWO
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param GameStoreRequest $request
     * @return RedirectResponse
     * @throws Throwable
     */
    public function store(GameStoreRequest $request): RedirectResponse
    {
        try {
            // $this->db->beginTransaction();

            if (! $request->has('player_symbol_one') || ! $request->has('player_symbol_two'))
            {
                throw new Exception('player symbols not found to restart the game.');
            }

            $this->initGame($request->get('player_symbol_one'), $request->get('player_symbol_two'));

            // $this->db->commit();
        } catch (Throwable $e) {
            // $this->db->rollBack();

            throw $e;
        }

        return redirect()->route('tictactoe.board');
    }

    /**
     * Display the specified resource.
     *
     * @return RedirectResponse|View
     * @throws Exception
     */
    public function board(): RedirectResponse|View
    {
        if (! $this->hasGame()) {
            return redirect()->route('tictactoe.index');
        }

        if ($this->getCurrentGame()->gameEnds())
        {
            $notifications = [
                [
                    'type' => $this->getCurrentGame()->gameTied()
                        ? 'warning'
                        : 'success',
                    'head' => $this->getCurrentGame()->gameTied()
                        ? 'Game was tied'
                        : 'Game has a winner',
                    'messages' => $this->getCurrentGame()->gameTied()
                        ? [
                            [
                                'text' => 'No winner or loser'
                            ],
                        ]
                        : [
                            [
                                'text' => sprintf(
                                    '%s <span class="badge badge-primary p-6">%s</span>',
                                    $this->getCurrentGame()->getWinnerName(),
                                    $this->getCurrentGame()->getWinnerSymbol()
                                )
                            ],
                        ]
                ]
            ];
        }

        return view('game')->with(['notifications' => $notifications ?? null]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws Exception
     */
    public function play(Request $request): RedirectResponse
    {
        try {
            $play = new Play(
                $request->has('position') ? $request->get('position') : null,
                $request->has('player-symbol') ? $request->get('player-symbol') : null,
                $request->has('current-play-order') ? (int) $request->get('current-play-order') : null,
            );

            $this->getCurrentGame()->play($play);
        } catch (Throwable $e) {
            // $this->db->rollBack();

            throw $e;
        }

        return redirect()->route('tictactoe.board');
    }

    /**
     * @return RedirectResponse
     * @throws Throwable
     */
    public function finish(Request $request): RedirectResponse
    {
        try {
            if (!$request->has('tictactoe-finish-input') || !$request->isMethod('post')) {
                throw new Exception('finish action not allowed.');
            }
            // $this->db->beginTransaction();

            if ($request->get('tictactoe-finish-input') === '1') {
                $this->destroyGame();

                // $this->db->commit();
            }
        } catch (Throwable $e) {
            // $this->db->rollBack();

            throw $e;
        }

        return redirect()->route('tictactoe.index');
    }

    /**
     * @return RedirectResponse
     * @throws Throwable
     */
    public function restart(Request $request): RedirectResponse
    {
        try {
            if (!$request->has('tictactoe-restart-input') || !$request->isMethod('post')) {
                throw new Exception('restart action not allowed.');
            }
            // $this->db->beginTransaction();

            if ($request->get('tictactoe-restart-input') === '1') {
                $this->endCurrentGame();
                $this->restartGame();

                // $this->db->commit();
            }
        } catch (Throwable $e) {
            // $this->db->rollBack();

            throw $e;
        }

        return redirect()->route('tictactoe.board');
    }
}
