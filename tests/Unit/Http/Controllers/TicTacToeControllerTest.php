<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Controllers;

use App\Repositories\GameHistoryRepository;
use Illuminate\Pagination\CursorPaginator;
use Tests\TestCase;

class TicTacToeControllerTest extends TestCase
{
    /**
     * @var GameHistoryRepository
     */
    protected GameHistoryRepository $gameHistoryRepository;

    /**
     * @var CursorPaginator
     */
    protected CursorPaginator $paginator;

    /**
     * Setup tests
     */
    public function setUp(): void
    {
        $this->gameHistoryRepository = $this->createMock(GameHistoryRepository::class);
        $this->paginator = $this->createMock(CursorPaginator::class);

        parent::setUp();
    }

    /**
     * Test view all histories.
     *
     * @return void
     */
    public function testViewAllHistoriesSucceeds()
    {
        $this->gameHistoryRepository->expects(self::once())
            ->method('getGameBySessionId')
            ->with('BKbadjadkaDKABJBSAdkja', 10, true)
            ->willReturn($this->paginator);

        $histories = $this->gameHistoryRepository->getGameBySessionId('BKbadjadkaDKABJBSAdkja', 10, true);

        $this->assertInstanceOf(CursorPaginator::class, $histories);
    }
}
