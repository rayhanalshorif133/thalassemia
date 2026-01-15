<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketSeries extends Model
{

    protected $table = 'ticket_series';

    protected $fillable = [
        'series',
        'ticket_number_range',
        'total_ticket',
    ];
}
