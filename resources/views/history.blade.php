@isset($gameHistories)
    <section class="board-history">
        <div id="accordion">
            @foreach($gameHistories->all() as $key => $gameHistory)
                <div @class([
                    'card',
                    'text-white',
                    'bg-primary' => $gameHistory->game->gameTied(),
                    'bg-success' => !$gameHistory->game->gameTied()
                ])>
                    <div class="card-header p-0 text-center" id="heading-{{ $key }}">
                        <h5 class="mb-0">
                            <button
                                class="btn text-white font-weight-bolder"
                                data-toggle="collapse"
                                data-target="#collapse-{{ $key }}"
                                aria-expanded="false"
                                aria-controls="collapse-{{ $key }}"
                            >
                                {!!
                                    $gameHistory->game->gameTied()
                                        ? 'Game tied'
                                        : 'Game has a winner: ' . sprintf(
                                            '<span class="badge badge-dark pt-1 pb-1 pl-2 pr-2">%s</span>',
                                            $gameHistory->game->getWinnerName()
                                        )
                                !!}
                            </button>
                        </h5>
                    </div>
                    <div
                        id="collapse-{{ $key }}"
                        class="collapse{{ !$key ? ' show' : '' }}"
                        aria-labelledby="heading-{{ $key }}"
                        data-parent="#accordion"
                    >
                        <div class="card-body">
                            <table class="table table-light table-tictactoe">
                                <tbody>
                                    @foreach($gameHistory->game->board->getBoard() as $row => $columns)
                                        <tr>
                                            @foreach($columns as $col => $value)
                                                @php
                                                    $winnerLineClass = $gameHistory
                                                        ->game
                                                        ->hasPositionInWinnerLine($row, $col);
                                                @endphp

                                                <td class="align-middle text-center {{ $winnerLineClass }}">
                                                    {!! $value ?? "&nbsp;" !!}
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endisset
