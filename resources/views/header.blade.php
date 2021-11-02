<header class="mb-3 shadow">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand btn btn-outline-primary" href="{{ route('tictactoe.index') }}">Tic-Tac-Toe</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active d-none d-sm-block">
                    <a class="nav-link" href="{{ route('tictactoe.board') }}">Game board <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                <a class="nav-link disabled" href="#">Game history</a>
                </li>
            </ul>

            {{ Form::open(['route' => 'tictactoe.restart', 'name' => 'tictactoe-restart', 'id' => 'tictactoe-restart', 'class' => 'form-inline my-2 my-lg-0']) }}
                {{ Form::hidden('tictactoe-restart-input', 1, ['id' => 'tictactoe-restart-input', 'class' => 'form-control']) }}
                {{ Form::submit('Restart', ['class' => 'btn btn-success mr-sm-2']) }}
            {{ Form::close() }}

            {{ Form::open(['route' => 'tictactoe.finish', 'name' => 'tictactoe-finish', 'id' => 'tictactoe-finish', 'class' => 'form-inline my-2 my-lg-0']) }}
                {{ Form::hidden('tictactoe-finish-input', 1, ['id' => 'tictactoe-finish-input', 'class' => 'form-control']) }}
                {{ Form::submit('Finish the game', ['class' => 'btn btn-outline-danger my-2 my-sm-0']) }}
            {{ Form::close() }}
        </div>
    </nav>
</header>
