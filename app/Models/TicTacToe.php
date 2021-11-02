<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicTacToe extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'tic_tac_toe';

    /**
     * @var string[]
     */
    protected $guarded = [
        'id'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'board_id',
        'player_symbol_one',
        'player_symbol_two',
        'play_history_id',
        'winner',
        'loser',
        'tied',
        'ends',
        'current_play_order',
        'player_symbol_starts',
        'player_symbol_allowed_to_play',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var string[]
     */
    protected $hidden = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $visible = [
        'id',
        'board_id',
        'player_symbol_one',
        'player_symbol_two',
        'play_history_id',
        'winner',
        'loser',
        'tied',
        'ends',
        'current_play_order',
        'player_symbol_starts',
        'player_symbol_allowed_to_play',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var string[]
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];
}
