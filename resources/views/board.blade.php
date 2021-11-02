@isset($board)
    <section class="board">
        <table class="table table-light table-tictactoe">
            <tbody>
                @foreach($board as $row => $columns)
                    <tr>
                        @forelse($columns as $col => $value)
                            @if(isset($historyMode) && $historyMode === true)
                                <td @class([
                                    'align-middle',
                                    'text-center',
                                    'highlight-diagonal-cross-inverse' => ($value['class'] ?? '') === 'highlight-diagonal-cross-inverse',
                                    'highlight-diagonal-cross' => ($value['class'] ?? '') === 'highlight-diagonal-cross',
                                    'highlight-horizontal-cross' => Str::startsWith(($value['class'] ?? ''), 'highlight-horizontal-cross'),
                                    'highlight-vertical-cross' => Str::startsWith(($value['class'] ?? ''), 'highlight-vertical-cross'),
                                ])>
                                    {!! $value['symbol'] ?? '&nbsp;' !!}
                                </td>
                            @else
                                @php
                                    $winnerLineClass = session()->get('game')->hasPositionInWinnerLine($row, $col);
                                @endphp
                                <td @class([
                                    'align-middle',
                                    'text-center',
                                    'highlight-diagonal-cross-inverse' => ($winnerLineClass ?? '') === 'highlight-diagonal-cross-inverse',
                                    'highlight-diagonal-cross' => ($winnerLineClass ?? '') === 'highlight-diagonal-cross',
                                    'highlight-horizontal-cross' => Str::startsWith(($winnerLineClass ?? ''), 'highlight-horizontal-cross'),
                                    'highlight-vertical-cross' => Str::startsWith(($winnerLineClass ?? ''), 'highlight-vertical-cross'),
                                ])>
                                    @if(session()->get('game')->gameEnds())
                                        {!! $value ?? '&nbsp;' !!}
                                    @else
                                        {{
                                            $value ?? Form::button('&nbsp;', [
                                                'class' => 'btn tictactoe-play-button',
                                                'onclick' => "document.getElementById('position').value = '".session()->get('game')->board->getBoardNamedPosition($row, $col)."';document.getElementById('tictactoe-play').submit();"
                                            ])
                                        }}
                                    @endif
                                </td>
                            @endisset
                        @empty
                            <td>No content</td>
                        @endforelse
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>
@endisset
