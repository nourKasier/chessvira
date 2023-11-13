<?php

namespace App;

use Database\Factories\ChessMatchFactory;
use Domain\Client\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChessMatch extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'chess_matches';

    protected static function newFactory(): Factory
    {
        return ChessMatchFactory::new();
    }

    protected $fillable = [
        'white_player_id',
        'black_player_id',
        'pgn',
    ];

    public function whitePlayer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'white_player_id');
    }

    public function blackPlayer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'black_player_id');
    }

    public function moves(): HasMany
    {
        return $this->hasMany(Move::class);
    }
}
