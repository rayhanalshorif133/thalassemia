<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'ticket_series_id',
        'ticket_no',
        'msisdn',
        'amount',
        'pay_status',
        'date',
        'response_data',
    ];


    public function ticketSeries()
    {
        return $this->belongsTo(TicketSeries::class, 'ticket_series_id');
    }  
    
    public function userID($msisdn)
    {

        $userHasToken = UserHasToken::select()->where('msisdn', $msisdn)->first();
        return  $userHasToken->token;
    }
}
