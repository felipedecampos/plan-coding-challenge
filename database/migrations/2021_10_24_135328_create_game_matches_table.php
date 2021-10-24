<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_matches', function (Blueprint $table) {
            $table->unsignedBigInteger();
            $table->unsignedBigInteger('game_id', false);
            $table->foreign('game_id')
                ->references('id')
                ->on('games');
            $table->unsignedBigInteger('player_id_starts', false)
                ->nullable();
            $table->foreign('player_id_starts')
                ->references('id')
                ->on('players');
            $table->boolean('match_ends')->nullable();
            $table->unsignedBigInteger('winner_player_id', false)
                ->nullable();
            $table->foreign('winner_player_id')
                ->references('id')
                ->on('players');
            $table->unsignedBigInteger('loser_player_id', false)
                ->nullable();
            $table->foreign('loser_player_id')
                ->references('id')
                ->on('players');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_matches');
    }
}
