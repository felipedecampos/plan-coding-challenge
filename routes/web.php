<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\TicTacToeController;
use App\TicTacToe\Game;
use App\TicTacToe\SetUp;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // X WINS 5 MOVES
    $game1 = new Game(1, 2, 'X');
    $game1->fillBoardWithPlays(
        collect([
            ['top-left',        'X', 1],
            ['middle-left',     'O', 2],
            ['top-middle',      'X', 3],
            ['middle-middle',   'O', 4],
            ['top-right',       'X', 5]
        ])
    );

    // O WINS 9 MOVES
    $game2 = new Game(1, 2, 'O');
    $game2->fillBoardWithPlays(
        collect([
            ['middle-left',     'O', 1],
            ['top-left',        'X', 2],
            ['top-middle',      'O', 3],
            ['middle-right',    'X', 4],
            ['middle-middle',   'O', 5],
            ['bottom-right',    'X', 6],
            ['top-right',       'O', 7],
            ['bottom-middle',   'X', 8],
            ['bottom-left',     'O', 9]
        ])
    );

    // TIED
    $game3 = new Game(1, 2, 'X');
    $game3->fillBoardWithPlays(
        collect([
            ['top-left',        'X', 1],
            ['middle-left',     'O', 2],
            ['top-middle',      'X', 3],
            ['middle-middle',   'O', 4],
            ['middle-right',    'X', 5],
            ['bottom-middle',   'O', 6],
            ['bottom-left',     'X', 7],
            ['top-right',       'O', 8],
            ['bottom-right',    'X', 9]
        ])
    );

    dd('X WINS 5 MOVES: ', $game1, 'O WINS 9 MOVES: ', $game2, 'TIED: ', $game3);
});

Route::get('/tic-tac-toe', [TicTacToeController::class, 'index'])
    ->name('tictactoe.index');

Route::post('/tic-tac-toe/store', [TicTacToeController::class, 'store'])
    ->name('tictactoe.store');

Route::get('/tic-tac-toe/board', [TicTacToeController::class, 'board'])
    ->name('tictactoe.board');

Route::post('/tic-tac-toe/play', [TicTacToeController::class, 'play'])
    ->name('tictactoe.play');

Route::post('/tic-tac-toe/restart', [TicTacToeController::class, 'restart'])
    ->name('tictactoe.restart');

Route::post('/tic-tac-toe/finish', [TicTacToeController::class, 'finish'])
    ->name('tictactoe.finish');

Route::get('/', function () {
    return view('indexBKP');
})->name('index');

Route::post('/game/store', [GameController::class, 'store'])
    ->name('game.store');

Route::get('/game/show', [GameController::class, 'show'])
    ->name('game.show');

Route::post('/player', [PlayerController::class, 'store'])
    ->name('player.store');

//    Route::get('/player/{id}/show', [PlayerController::class, 'show'])
//        ->where('id', '[0-9]+')
//        ->name('player.show');

//    Route::post('/play/{playerId}/store', [PlayController::class, 'store'])
//        ->name('play.store');
