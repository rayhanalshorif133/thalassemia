<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserHasToken extends Model
{

    protected $table = 'user_has_token';

    protected $fillable = [
        'msisdn',
        'token',
        'last_ticket_id',
        'type',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public $timestamps = false;
}
