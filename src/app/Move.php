<?php

namespace App;

use Database\Factories\MoveFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Move extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'moves';

    protected static function newFactory(): Factory
    {
        return MoveFactory::new();
    }

    protected $fillable = [
        'match_id',
        'number',
        'san',
    ];

    public function match(): BelongsTo
    {
        return $this->belongsTo(ChessMatch::class);
    }
}
