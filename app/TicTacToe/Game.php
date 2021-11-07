<?php

declare(strict_types=1);

namespace App\TicTacToe;

use Exception;
use Illuminate\Support\Collection;

class Game extends SetUp
{
    /**
     * @var Board
     */
    public Board $board;

    /**
     * @var string $playerSymbolOne
     */
    protected string $playerSymbolOne;

    /**
     * @var string $playerSymbolTwo
     */
    protected string $playerSymbolTwo;

    /**
     * @var Collection $playHistory
     */
    protected Collection $playHistory;

    /**
     * @var string $winnerSymbol
     */
    protected string $winnerSymbol = "";

    /**
     * @var string $winnerName
     */
    protected string $winnerName = "";

    /**
     * @var string $loserSymbol
     */
    protected string $loserSymbol = "";

    /**
     * @var string $loserName
     */
    protected string $loserName = "";

    /**
     * @var bool $tied
     */
    protected bool $tied = false;

    /**
     * @var bool $ends
     */
    protected bool $ends = false;

    /**
     * @var int $currentPlayOrder
     */
    protected int $currentPlayOrder = 1;

    /**
     * @var string $playerSymbolStarts
     */
    protected string $playerSymbolStarts;

    /**
     * @var string $playerSymbolAllowedToPlay
     */
    protected string $playerSymbolAllowedToPlay;

    /**
     * @var array
     */
    protected array $winnerLine = [];

    /**
     * Game constructor.
     * @param string $playerSymbolOne
     * @param string $playerSymbolTwo
     * @param string $playerSymbolAllowedToPlay
     * @throws Exception
     */
    public function __construct(
        string $playerSymbolOne,
        string $playerSymbolTwo,
        string $playerSymbolAllowedToPlay = ""
    ) {
        $this->board           = new Board();
        $this->playerSymbolOne = $playerSymbolOne;
        $this->playerSymbolTwo = $playerSymbolTwo;
        $this->playHistory     = collect([]);

        if (empty($playerSymbolAllowedToPlay)) {
            $playerSymbolAllowedToPlay = $this->getRandomPlayerSymbol();
        }

        $this->checkPLayerSymbol($playerSymbolAllowedToPlay);

        $this->playerSymbolAllowedToPlay = $playerSymbolAllowedToPlay;
    }

    /**
     * @return array
     */
    private function checkStatus(): array
    {
        $ends         = $this->gameEnds();
        $tied         = $this->tied;
        $winnerSymbol = $this->winnerSymbol;
        $loserSymbol  = $this->loserSymbol;
        $winnerName   = $this->winnerName;
        $loserName    = $this->loserName;
        $playEnds     = $this->currentPlayOrder >= max(self::PLAY_ORDERS);

        if ($ends) {
            return [$ends, $tied, $winnerSymbol, $loserSymbol];
        }

        $currentWinnerLineKey = 1;

        foreach ($this->board->getWinnerLines() as $keyLines => $lines) {
            $playerWinnerLine = collect([]);
            $lastWinnerLine   = $currentWinnerLineKey >= count($this->board->getWinnerLines());

            foreach ($lines as $positions) {
                $row = $positions[0];
                $col = $positions[1];

                $playerWinnerLine->push($this->board->getBoard()[$row][$col]);
            }

            if ($playerWinnerLine->isEmpty()) {
                continue;
            }

            $winnerSymbolOne = $playerWinnerLine->every(fn($playerSymbol) => $playerSymbol === self::PLAYER_SYMBOL_ONE);

            if ($winnerSymbolOne) {
                $winnerSymbol     = self::PLAYER_SYMBOL_ONE;
                $winnerName       = $this->playerSymbolOne;
                $loserSymbol      = self::PLAYER_SYMBOL_TWO;
                $loserName        = $this->playerSymbolTwo;
                $this->winnerLine = [$keyLines => $lines];
            }

            $winnerSymbolTwo = $playerWinnerLine->every(fn($playerSymbol) => $playerSymbol === self::PLAYER_SYMBOL_TWO);

            if ($winnerSymbolTwo) {
                $winnerSymbol     = self::PLAYER_SYMBOL_TWO;
                $winnerName       = $this->playerSymbolTwo;
                $loserSymbol      = self::PLAYER_SYMBOL_ONE;
                $loserName        = $this->playerSymbolOne;
                $this->winnerLine = [$keyLines => $lines];
            }

            $tied = (!$winnerSymbolOne && !$winnerSymbolTwo) && $playEnds && $lastWinnerLine;

            $currentWinnerLineKey++;

            if ($winnerSymbolOne || $winnerSymbolTwo || $tied) {
                $ends = true;
                break;
            }
        }

        return [$ends, $tied, $winnerSymbol, $winnerName, $loserSymbol, $loserName];
    }

    /**
     * @param Play $play
     * @return void
     * @throws Exception
     */
    private function updateGameStatus(Play $play): void
    {
        [$ends, $tied, $winnerSymbol, $winnerName, $loserSymbol, $loserName] = $this->checkStatus();

        if ($ends) {
            $this->ends         = $ends;
            $this->tied         = $tied;
            $this->winnerSymbol = $winnerSymbol;
            $this->winnerName   = $winnerName;
            $this->loserSymbol  = $loserSymbol;
            $this->loserName    = $loserName;
        }

        $this->setNextPlayerAllowedToPlay($play->playerSymbol);

        if (!$ends) {
            $this->currentPlayOrder++;
        }
    }

    /**
     * @return bool
     */
    public function gameEnds(): bool
    {
        return $this->ends;
    }

    public function gameTied(): bool
    {
        return $this->tied;
    }

    /**
     * @return string
     */
    public function getWinnerSymbol(): string
    {
        return $this->winnerSymbol;
    }

    /**
     * @return string
     */
    public function getWinnerName(): string
    {
        return $this->winnerName;
    }

    /**
     * @return string
     */
    public function getLoserSymbol(): string
    {
        return $this->loserSymbol;
    }

    /**
     * @return string
     */
    public function getLoserName(): string
    {
        return $this->loserName;
    }

    /**
     * @return Collection
     */
    public function getPlayHistory(): Collection
    {
        return $this->playHistory;
    }

    /**
     * @return array
     */
    public function getWinnerLine(): array
    {
        return $this->winnerLine;
    }

    /**
     * @param int $row
     * @param int $col
     * @return string
     * @throws Exception
     */
    public function hasPositionInWinnerLine(int $row, int $col): string
    {
        if (count($this->getWinnerLine()) > 1) {
            throw new Exception('winner line exceeds the limit');
        }

        $winnerLine = $this->getWinnerLine();

        $hasPosition = count(
            array_filter(
                current($winnerLine) ?: [],
                fn($position): bool => $position[0] === $row && $position[1] === $col
            )
        );

        return $hasPosition ? key($winnerLine) : '';
    }

    /**
     * @param Play $play
     * @return void
     * @throws Exception
     */
    private function checkAvailabilityToPlay(Play $play): void
    {
        if ($this->gameEnds()) {
            throw new Exception('play not allowed, there is no availability to play');
        }

        if (!$this->board->checkPositionAvailability($play->position)) {
            throw new Exception(sprintf('position not available to play: %s.', $play->position));
        }
    }

    /**
     * @return string
     */
    public function getPlayerSymbolAllowedToPlay(): string
    {
        return $this->playerSymbolAllowedToPlay;
    }

    /**
     * @return int
     */
    public function getCurrentPlayOrder(): int
    {
        return $this->currentPlayOrder;
    }

    /**
     * @param string $currentPlayerSymbol
     * @return void
     * @throws Exception
     */
    private function setNextPlayerAllowedToPlay(string $currentPlayerSymbol): void
    {
        $this->checkPLayerSymbol($currentPlayerSymbol);

        $this->playerSymbolAllowedToPlay = collect(self::PLAYER_SYMBOLS)
            ->reject(fn($playerSymbol) => $playerSymbol === $currentPlayerSymbol)
            ->first();
    }

    /**
     * @param Play $play
     * @return array
     * @throws Exception
     */
    public function play(Play $play): array
    {
        $this->checkAvailabilityToPlay($play);

        $play->checkPlayerSymbolAllowedToPlay($this->playerSymbolAllowedToPlay);
        $play->checkPlayerOrderAllowedToPlay($this->currentPlayOrder);

        if ($this->currentPlayOrder === 1) {
            $this->playerSymbolStarts = $play->playerSymbol;
        }

        $this->playHistory->put($play->playOrder, $play);

        $board = $this->board->fillBoard($play);

        $this->updateGameStatus($play);

        return $board;
    }

    /**
     * @param Collection $plays
     * @return array
     * @throws Exception
     */
    public function fillBoardWithPlays(Collection $plays): array
    {
        $playHistory = $plays
            ->transform(function (array $play) {
                [$position, $playerSymbol, $playOrder] = $play;
                return new Play($position, $playerSymbol, $playOrder);
            })
            ->sortBy('playOrder')
            ->map(function (Play $play) {
                return $this->play($play);
            });

        return $playHistory->last();
    }
}
