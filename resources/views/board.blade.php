@isset($game)
    <section class="board">
        <table class="table table-light table-tictactoe">
            <tbody>
                @foreach($game->board->getBoard() as $row => $columns)
                    <tr>
                        @forelse($columns as $col => $value)
                            @php
                                $winnerLineClass = $game->hasPositionInWinnerLine($row, $col);
                            @endphp
                            <td class="align-middle text-center {{ $winnerLineClass }}">
                                @if($game->gameEnds())
                                    {!! $value ?? '&nbsp;' !!}
                                @else
                                    {{
                                        $value ?? Form::button('&nbsp;', [
                                            'class' => 'btn tictactoe-play-button',
                                            'data-position' => $game->board->getBoardNamedPosition($row, $col),
                                        ])
                                    }}
                                @endif
                            </td>
                        @empty
                            <td>No content</td>
                        @endforelse
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>
@endisset
