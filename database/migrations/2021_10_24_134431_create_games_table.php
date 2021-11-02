<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('player_one_id', false);
            $table->foreign('player_one_id')
                ->references('id')
                ->on('players');
            $table->unsignedBigInteger('player_two_id', false);
            $table->foreign('player_two_id')
                ->references('id')
                ->on('players');
            $table->unsignedBigInteger('player_id_symbol_x', false);
            $table->foreign('player_id_symbol_x')
                ->references('id')
                ->on('players');
            $table->unsignedBigInteger('player_id_symbol_o', false);
            $table->foreign('player_id_symbol_o')
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
        Schema::dropIfExists('games');
    }
}
