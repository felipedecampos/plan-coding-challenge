@extends('layout')

@section('title', 'Tic-Tac-Toe')

@section('content')
    <section class="container index mt-3">
        <div class="bg-white shadow sm:rounded-lg">
            <div class="container-fluid">
                <div class="row flex-nowrap align-items-center">
                    <div class="col py-3">
                        <div class="d-flex justify-content-center">
                            {{
                                Form::open([
                                    'route' => 'tictactoe.store',
                                    'name' => 'tictactoe-store',
                                    'id' => 'tictactoe-store'
                                ])
                            }}
                                <div class="form-group text-center text-dark">
                                    {{
                                        Form::label(
                                            'player_symbol_one_label',
                                            "Player {$playerSymbolOne}:",
                                            [
                                                'for' => 'player_symbol_one',
                                                'class' => 'text-dark font-weight-bold'
                                            ]
                                        )
                                    }}
                                    {{
                                        Form::text(
                                            'player_symbol_one',
                                            null,
                                            [
                                                'id' => 'player_symbol_one',
                                                'class' => 'form-control',
                                                'placeholder' => "nickname"
                                            ]
                                        )
                                    }}
                                </div>

                                <div class="form-group text-center text-dark">
                                    {{
                                        Form::label(
                                            'player_symbol_two_label',
                                            "Player {$playerSymbolTwo}:",
                                            [
                                                'for' => 'player_symbol_two',
                                                'class' => 'text-dark font-weight-bold'
                                            ]
                                        )
                                    }}
                                    {{
                                        Form::text(
                                            'player_symbol_two',
                                            null,
                                            [
                                                'id' => 'player_symbol_two',
                                                'class' => 'form-control',
                                                'placeholder' => "nickname"
                                            ]
                                        )
                                    }}
                                </div>

                                <div class="mt-8 d-flex justify-content-center">
                                    {{ Form::submit('Initiate game', ['class' => 'btn btn-primary']) }}
                                </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
