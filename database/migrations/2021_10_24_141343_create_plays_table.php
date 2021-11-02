<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plays', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('game_match_id', false);
            $table->foreign('game_match_id')
                ->references('id')
                ->on('game_matches');
            $table->unsignedBigInteger('player_id', false);
            $table->foreign('player_id')
                ->references('id')
                ->on('players');
            $table->enum('position', [
                'top-left',
                'top-middle',
                'top-right',
                'middle-left',
                'middle-middle',
                'middle-right',
                'bottom-left',
                'bottom-middle',
                'bottom-right'
            ]);
            $table->smallInteger('play');
            $table->unique(['game_match_id', 'position']);
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
        Schema::dropIfExists('plays');
    }
}
