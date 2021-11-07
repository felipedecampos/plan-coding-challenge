<?php

declare(strict_types=1);

namespace App\TicTacToe;

use Exception;

/**
 * Class Play
 * @package App\TicTacToe\Play
 */
class Play extends SetUp
{
    /**
     * @var string $position
     */
    public string $position;

    /**
     * @var string $playerSymbol
     */
    public string $playerSymbol;

    /**
     * @var int $playOrder
     */
    public int $playOrder;

    /**
     * @param string $position
     * @param string $playerSymbol
     * @param int $playOrder
     * @throws Exception
     */
    public function __construct(string $position, string $playerSymbol, int $playOrder)
    {
        $this->checkBoardPosition($position);
        $this->checkPLayerSymbol($playerSymbol);
        $this->checkPLayOrder($playOrder);

        $this->position     = $position;
        $this->playerSymbol = $playerSymbol;
        $this->playOrder    = $playOrder;
    }

    /**
     * @param string $playerSymbolAllowed
     * @return void
     * @throws Exception
     */
    public function checkPlayerSymbolAllowedToPlay(string $playerSymbolAllowed): void
    {
        if ($this->playerSymbol !== $playerSymbolAllowed) {
            throw new Exception(
                sprintf(
                    'player symbol mismatch with player symbol allowed to play: %s <> %s.',
                    $this->playerSymbol,
                    $playerSymbolAllowed
                )
            );
        }
    }

    /**
     * @param int $currentPlayOrder
     * @return void
     * @throws Exception
     */
    public function checkPlayerOrderAllowedToPlay(int $currentPlayOrder): void
    {
        if ($this->playOrder !== $currentPlayOrder) {
            throw new Exception(
                sprintf(
                    'current play order mismatch with play order allowed to play: %d <> %d.',
                    $currentPlayOrder,
                    $this->playOrder
                )
            );
        }
    }
}
