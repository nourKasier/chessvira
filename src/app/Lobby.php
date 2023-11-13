<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lobby extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'lobbies';

    protected $fillable = ['player1_id', 'player2_id', 'status'];

    // protected static function newFactory(): Factory
    // {
    //     return ChessMatchFactory::new();
    // }

    public function player1()
    {
        return $this->belongsTo(User::class, 'player1_id');
    }

    public function player2()
    {
        return $this->belongsTo(User::class, 'player2_id');
    }
}
