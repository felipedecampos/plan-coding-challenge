@extends('layout')

@section('title', 'Tic-Tac-Toe')

@section('content')
    <section class="container board">
        <div class="bg-white shadow sm:rounded-lg">
            <div class="container-fluid">
                <div class="row flex-nowrap align-items-center">
                    <div class="col py-3">
                        <div class="d-flex justify-content-center">
                            @if(session()->has('game'))
                                {{ Form::open(['route' => 'tictactoe.play', 'name' => 'tictactoe-play', 'id' => 'tictactoe-play', 'class' => 'form-inline my-2 my-lg-0']) }}
                                    <div class="form-group">
                                        {{ Form::hidden('position', null, ['id' => 'position', 'class' => 'form-control']) }}
                                        {{ Form::hidden('player-symbol', session()->get('game')->getPlayerSymbolAllowedToPlay(), ['id' => 'player-symbol', 'class' => 'form-control']) }}
                                        {{ Form::hidden('current-play-order', session()->get('game')->getCurrentPlayOrder(), ['id' => 'current-play-order', 'class' => 'form-control']) }}
                                    </div>

                                    @include('board', ['board' => session()->get('game')->board->getBoard()])
                                {{ Form::close() }}
                            @endif
                        </div>
                    </div>
                    <div class="col-auto col-md-6 col-xl-4 px-sm-4 bg-gray-100 d-none d-sm-block">
                        <div class="d-flex justify-content-center flex-column align-items-center px-3 pt-2 text-white pb-4">
                            <div class="d-flex justify-content-center pb-3 pt-3 mb-md-0 me-md-auto text-dark text-decoration-none">
                                <span class="fs-5 d-none d-sm-inline">Latest games</span>
                            </div>
                            <div id="accordion">
                                <div class="card text-white bg-success">
                                    <div class="card-header p-0 text-center" id="heading-1">
                                        <h5 class="mb-0">
                                            <button class="btn text-white font-weight-bolder" data-toggle="collapse" data-target="#collapse-1" aria-expanded="false" aria-controls="collapse-1">
                                                The game has a winner: <span class="badge badge-dark pt-1 pb-1 pl-2 pr-2">X</span>
                                            </button>
                                        </h5>
                                    </div>
                                    <div id="collapse-1" class="collapse show" aria-labelledby="heading-1" data-parent="#accordion">
                                        <div class="card-body">
                                            <table class="table board-table">
                                                <tbody>
                                                    @foreach(session()->get('game')->board->getBoard() as $row => $columns)
                                                        <tr>
                                                            @foreach($columns as $col => $value)
                                                                <td class="p-6 bg-white text-center">
                                                                    {{
                                                                        $value ?? Form::button('Play', [
                                                                            'class' => 'btn btn-primary',
                                                                            'onclick' => "document.getElementById('position').value = '".session()->get('game')->board->getBoardNamedPosition($row, $col)."';document.getElementById('tictactoe-play').submit();"
                                                                        ])
                                                                    }}
                                                                </td>
                                                            @endforeach
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="card text-white bg-secondary">
                                    <div class="card-header p-0 text-center" id="heading-2">
                                        <h5 class="mb-0">
                                            <button class="btn text-white font-weight-bolder" data-toggle="collapse" data-target="#collapse-2" aria-expanded="false" aria-controls="collapse-2">
                                                Tha game was tied
                                            </button>
                                        </h5>
                                    </div>
                                    <div id="collapse-2" class="collapse" aria-labelledby="heading-2" data-parent="#accordion">
                                        <div class="card-body">
                                            <table class="table board-table">
                                                <tbody>
                                                    @foreach(session()->get('game')->board->getBoard() as $row => $columns)
                                                        <tr>
                                                            @foreach($columns as $col => $value)
                                                                <td class="p-6 bg-white text-center">
                                                                    {{
                                                                        $value ?? Form::button('Play', [
                                                                            'class' => 'btn btn-primary',
                                                                            'onclick' => "document.getElementById('position').value = '".session()->get('game')->board->getBoardNamedPosition($row, $col)."';document.getElementById('tictactoe-play').submit();"
                                                                        ])
                                                                    }}
                                                                </td>
                                                            @endforeach
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
