<?php

declare(strict_types=1);

namespace App\TicTacToe;

use Exception;
use Illuminate\Support\Arr;

/**
 * Class SetUp
 * @package App\TicTacToe\SetUp
 */
abstract class SetUp
{
    public const PLAYER_SYMBOL_ONE = 'X';

    public const PLAYER_SYMBOL_TWO = 'O';

    protected const PLAYER_SYMBOLS = [
        self::PLAYER_SYMBOL_ONE,
        self::PLAYER_SYMBOL_TWO
    ];

    protected const BOARD_POSITIONS = [
        'top-left',
        'top-middle',
        'top-right',
        'middle-left',
        'middle-middle',
        'middle-right',
        'bottom-left',
        'bottom-middle',
        'bottom-right',
    ];

    protected const PLAY_ORDERS = [
        1,
        2,
        3,
        4,
        5,
        6,
        7,
        8,
        9,
    ];

    /**
     * @param string $playerSymbol
     * @return void
     * @throws Exception
     */
    protected function checkPLayerSymbol(string $playerSymbol): void
    {
        if (!in_array($playerSymbol, self::PLAYER_SYMBOLS, true)) {
            throw new Exception(
                sprintf(
                    'player symbol not allowed to use: %s.',
                    $playerSymbol
                )
            );
        }
    }

    /**
     * @param int $playOrder
     * @return void
     * @throws Exception
     */
    protected function checkPLayOrder(int $playOrder): void
    {
        if (!in_array($playOrder, self::PLAY_ORDERS, true)) {
            throw new Exception(sprintf('play order not allowed to play: %d.', $playOrder));
        }
    }

    /**
     * @param string $position
     * @return void
     * @throws Exception
     */
    protected function checkBoardPosition(string $position): void
    {
        if (!in_array($position, self::BOARD_POSITIONS, true))
        {
            throw new Exception(sprintf('position not allowed to play: %s.', $position));
        }
    }

    /**
     * @return string
     */
    protected function getRandomPlayerSymbol(): string
    {
        return Arr::random(self::PLAYER_SYMBOLS);
    }
}
