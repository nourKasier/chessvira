<?php

namespace App;

use Database\Factories\ContactFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'contacts';

    protected static function newFactory(): Factory
    {
        return ContactFactory::new();
    }

    protected $fillable = ['name', 'email', 'subject', 'message'];
}
