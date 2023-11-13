<?php

namespace App;

use Database\Factories\MessageFactory;
use Domain\Client\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'messages';

    protected static function newFactory(): Factory
    {
        return MessageFactory::new();
    }

    protected $fillable = [
        'user_id',
        'match_id',
        'content',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function match(): BelongsTo
    {
        return $this->belongsTo(ChessMatch::class);
    }
}
