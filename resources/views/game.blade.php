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
                                {{
                                    Form::open([
                                        'route' => 'tictactoe.play',
                                        'name' => 'tictactoe-play',
                                        'id' => 'tictactoe-play',
                                        'class' => 'form-inline my-2 my-lg-0'
                                    ])
                                }}
                                    <div class="form-group">
                                        {{
                                            Form::hidden(
                                                'position',
                                                null,
                                                ['id' => 'position', 'class' => 'form-control']
                                            )
                                        }}
                                        {{
                                            Form::hidden(
                                                'player-symbol',
                                                session()->get('game')->getPlayerSymbolAllowedToPlay(),
                                                ['id' => 'player-symbol', 'class' => 'form-control']
                                            )
                                        }}
                                        {{
                                            Form::hidden(
                                                'current-play-order',
                                                session()->get('game')->getCurrentPlayOrder(),
                                                ['id' => 'current-play-order', 'class' => 'form-control']
                                            )
                                        }}
                                    </div>

                                    @include('board', ['game' => session()->get('game')])
                                {{ Form::close() }}
                            @endif
                        </div>
                    </div>
                    <div class="col-auto col-md-6 col-xl-4 px-sm-4 d-none d-sm-block">
                        <div class="d-flex justify-content-center flex-column align-items-center px-3 pt-2 pb-4">
                            <div class="d-flex justify-content-center pb-3 pt-3 text-dark text-decoration-none h4">
                                <span class="fs-5 d-none d-sm-inline font-weight-bold legend">Latest games</span>
                            </div>

                            @includeWhen(isset($gameHistories), 'history')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
