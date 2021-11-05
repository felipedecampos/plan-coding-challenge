<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\GameStoreRequest;
use App\Repositories\GameHistoryRepository;
use App\TicTacToe\Game;
use App\TicTacToe\Play;
use App\TicTacToe\SetUp;
use Exception;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TicTacToeController extends Controller
{
    /**
     * @var GameHistoryRepository
     */
    protected GameHistoryRepository $gameHistoryRepository;

    /**
     * @param GameHistoryRepository $gameHistoryRepository
     */
    public function __construct(GameHistoryRepository $gameHistoryRepository)
    {
        $this->gameHistoryRepository = $gameHistoryRepository;
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
        if (!$this->hasGame()) {
            throw new Exception('game not found');
        }

        return session()->get('game');
    }

    /**
     * @return void
     */
    private function destroyGame(): void
    {
        session()->flush();
        session()->regenerate();
    }

    /**
     * @return void
     */
    private function endCurrentGame(): void
    {
        session()->forget('game');
        session()->forget('game_id');
    }

    /**
     * @return void
     * @throws Exception
     */
    private function restartGame(): void
    {
        if (!session()->has('player_symbol_one') || !session()->has('player_symbol_two')) {
            throw new Exception('player symbols not found to restart the game.');
        }

        $this->initGame(session()->get('player_symbol_one'), session()->get('player_symbol_two'));
    }

    /**
     * @return void
     * @throws Exception
     */
    private function saveCurrentGame(): void
    {
        if (!$this->hasGame()) {
            throw new Exception('game not found to save.');
        }

        $gameHistory = $this->gameHistoryRepository->createGame([
            'session_id' => session()->getId(),
            'game' => serialize(session()->get('game')),
        ]);

        session()->put('game_id', $gameHistory->getAttribute('id'));
    }

    /**
     * @return void
     * @throws Exception
     */
    private function updateCurrentGame(): void
    {
        if (!$this->hasGame() || !session()->has('game_id')) {
            throw new Exception('game not found to update.');
        }

        $this->gameHistoryRepository->update(session()->get('game_id'), [
            'session_id' => session()->getId(),
            'game' => serialize(session()->get('game')),
        ]);
    }

    /**
     * @param string $sessionId
     * @param int|bool $take
     * @param bool $paginate
     * @return Paginator|Collection
     */
    protected function getGameHistory(string $sessionId, int|bool $take = false, bool $paginate = false): Paginator|Collection
    {
        return $this->gameHistoryRepository->getGameBySessionId($sessionId, $take, $paginate);
    }

    /**
     * @return RedirectResponse|View
     * @throws Exception
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
     * @param GameStoreRequest $request
     * @return RedirectResponse
     * @throws Exception
     */
    public function store(GameStoreRequest $request): RedirectResponse
    {
        if (!$request->has('player_symbol_one') || !$request->has('player_symbol_two')) {
            throw new Exception('player symbols not found to start the game.');
        }

        $this->initGame($request->get('player_symbol_one'), $request->get('player_symbol_two'));

        return redirect()->route('tictactoe.board');
    }

    /**
     * @return RedirectResponse|View
     * @throws Exception
     */
    public function board(): RedirectResponse|View
    {
        if (!$this->hasGame()) {
            return redirect()->route('tictactoe.index');
        }

        if ($this->getCurrentGame()->gameEnds()) {
            $notifications = [
                [
                    'type' => $this->getCurrentGame()->gameTied()
                        ? 'warning'
                        : 'success',
                    'head' => $this->getCurrentGame()->gameTied()
                        ? 'Game is tied'
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

        return view('game')->with([
            'notifications' => $notifications ?? null,
            'gameHistories' => $this->getGameHistory(session()->getId(), 5)
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws Exception
     */
    public function play(Request $request): RedirectResponse
    {
        $play = new Play(
            $request->has('position') ? $request->get('position') : null,
            $request->has('player-symbol') ? $request->get('player-symbol') : null,
            $request->has('current-play-order') ? (int)$request->get('current-play-order') : null,
        );

        $this->getCurrentGame()->play($play);

        if ($this->getCurrentGame()->gameEnds()) {
            $this->saveCurrentGame();
        }

        return redirect()->route('tictactoe.board');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws Exception
     */
    public function finish(Request $request): RedirectResponse
    {
        if (!$request->has('tictactoe-finish-input')) {
            throw new Exception('finish action not allowed.');
        }

        if ($request->get('tictactoe-finish-input') === '1') {
            $this->destroyGame();
        }

        return redirect()->route('tictactoe.index');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws Exception
     */
    public function restart(Request $request): RedirectResponse
    {
        if (!$request->has('tictactoe-restart-input')) {
            throw new Exception('restart action not allowed.');
        }

        if ($request->get('tictactoe-restart-input') === '1') {
            $this->endCurrentGame();
            $this->restartGame();
        }

        return redirect()->route('tictactoe.board');
    }
}
