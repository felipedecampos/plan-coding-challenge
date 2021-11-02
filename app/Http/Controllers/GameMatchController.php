<?php

namespace App\Http\Controllers;

use App\Http\Requests\GameMatchStoreRequest;
use App\Repositories\GameMatchRepository;
use Exception;
use Illuminate\Http\Response;
use Throwable;

class GameMatchController extends Controller
{
    /**
     * @var GameMatchRepository
     */
    protected GameMatchRepository $gameMatchRepository;

    /**
     * @param GameMatchRepository $gameMatchRepository
     */
    public function __construct(GameMatchRepository $gameMatchRepository)
    {
        $this->gameMatchRepository = $gameMatchRepository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param GameMatchStoreRequest $request
     * @return Response
     * @throws Throwable
     */
    public function store(GameMatchStoreRequest $request)
    {
        try {
            $gameMatch = $this->gameMatchRepository->createGameMatch($request->toArray());

            if (is_null($gameMatch)) {
                throw new Exception('Game match not created, please, try again soon.');
            }
        } catch (Throwable $e) {
            throw $e;
        }

        redirect()->route('game');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }
}
