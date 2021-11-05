<?php

declare(strict_types=1);

use App\Http\Controllers\TicTacToeController;
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

Route::get('/', [TicTacToeController::class, 'index'])
    ->name('tictactoe.index');

Route::post('/store', [TicTacToeController::class, 'store'])
    ->name('tictactoe.store');

Route::get('/board', [TicTacToeController::class, 'board'])
    ->name('tictactoe.board');

Route::post('/play', [TicTacToeController::class, 'play'])
    ->name('tictactoe.play');

Route::post('/restart', [TicTacToeController::class, 'restart'])
    ->name('tictactoe.restart');

Route::post('/finish', [TicTacToeController::class, 'finish'])
    ->name('tictactoe.finish');
