<?php

declare(strict_types=1);

namespace App\TicTacToe;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Board
 * @package App\TicTacToe\Board
 */
class Board extends SetUp
{
    use HasFactory;

    /**
     * @var int
     */
    private const ROWS_LIMIT = 3;

    /**
     * @var int
     */
    private const COLS_LIMIT = 3;

    /**
     * @var array
     */
    protected array $board;

    /**
     * @var array $winnerLines
     */
    protected array $winnerLines;

    /**
     * Board constructor.
     */
    public function __construct()
    {
        $this->board = $this->generateBoard();
    }

    /**
     * @return array
     */
    private function generateBoard(): array
    {
        $board      = [];
        $rowLines   = [];
        $colLines   = [];
        $lDiagLines = [];
        $rDiagLines = [];

        for ($row = 0; $row < self::ROWS_LIMIT; $row++) {
            for ($col = 0; $col < self::COLS_LIMIT; $col++) {
                $board [$row][$col] = null;

                $rowLines ['highlight-horizontal-cross-' . $row][]= [$row, $col];
                $colLines ['highlight-vertical-cross-' . $col][]= [$row, $col];

                if ($row === $col) {
                    $lDiagLines ['highlight-diagonal-cross'][]= [$row, $col];
                }

                if ($col === ((self::COLS_LIMIT-1)-$row)) {
                    $rDiagLines ['highlight-diagonal-cross-inverse'][]= [$row, $col];
                }
            }
        }

        $this->winnerLines = array_merge($rowLines, $colLines, $lDiagLines, $rDiagLines);

        return $board;
    }

    /**
     * @return array
     */
    public function getBoard(): array
    {
        return $this->board;
    }

    /**
     * @return array
     */
    public function getWinnerLines(): array
    {
        return $this->winnerLines;
    }

    /**
     * @param int $row
     * @return void
     * @throws Exception
     */
    private function checkRowRange(int $row): void
    {
        if (!in_array($row, range(0, self::ROWS_LIMIT), true))
        {
            throw new Exception(sprintf('row given mismatch the range of rows allowed: %d.', $row));
        }
    }

    /**
     * @param int $col
     * @return void
     * @throws Exception
     */
    private function checkColRange(int $col): void
    {
        if (!in_array($col, range(0, self::COLS_LIMIT), true))
        {
            throw new Exception(sprintf('col given mismatch the range of cols allowed: %d.', $col));
        }
    }

    /**
     * @param int $row
     * @param int $col
     * @return string
     * @throws Exception
     */
    public function getBoardNamedPosition(int $row, int $col): string
    {
        $this->checkRowRange($row);
        $this->checkColRange($col);

        $position = [];

        switch ([$row, $col]) {
            case [0, 0]:
                $position = 'top-left';
                break;
            case [0, 1]:
                $position = 'top-middle';
                break;
            case [0, 2]:
                $position = 'top-right';
                break;
            case [1, 0]:
                $position = 'middle-left';
                break;
            case [1, 1]:
                $position = 'middle-middle';
                break;
            case [1, 2]:
                $position = 'middle-right';
                break;
            case [2, 0]:
                $position = 'bottom-left';
                break;
            case [2, 1]:
                $position = 'bottom-middle';
                break;
            case [2, 2]:
                $position = 'bottom-right';
                break;
        }

        return $position;
    }

    /**
     * @param string $position
     * @return array
     * @throws Exception
     */
    private function getBoardPosition(string $position): array
    {
        $this->checkBoardPosition($position);

        $positions = [];

        switch ($position) {
            case 'top-left':
                $positions = [0, 0];
                break;
            case 'top-middle':
                $positions = [0, 1];
                break;
            case 'top-right':
                $positions = [0, 2];
                break;
            case 'middle-left':
                $positions = [1, 0];
                break;
            case 'middle-middle':
                $positions = [1, 1];
                break;
            case 'middle-right':
                $positions = [1, 2];
                break;
            case 'bottom-left':
                $positions = [2, 0];
                break;
            case 'bottom-middle':
                $positions = [2, 1];
                break;
            case 'bottom-right':
                $positions = [2, 2];
                break;
        }

        return $positions;
    }

    /**
     * @param Play $play
     * @return array
     * @throws Exception
     */
    public function fillBoard(Play $play): array
    {
        [$row, $col] = $this->getBoardPosition($play->position);

        $this->board[$row][$col] = $play->playerSymbol;

        return $this->getBoard();
    }

    /**
     * @param string $position
     * @return bool
     * @throws Exception
     */
    public function checkPositionAvailability(string $position): bool
    {
        [$row, $col] = $this->getBoardPosition($position);

        return empty($this->board[$row][$col]);
    }
}
