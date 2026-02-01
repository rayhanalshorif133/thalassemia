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
        'status',
        'gp_status',
        'send_sms',
        'date',
        'response_data',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function ticketSeries()
    {
        return $this->belongsTo(TicketSeries::class, 'ticket_series_id');
    }  
    
    public function userID($msisdn)
    {

        $userHasToken = UserHasToken::select()->where('msisdn', $msisdn)->first();
        if($userHasToken == null){
            return  "Token not Found";
        }
        return  $userHasToken->token;
    }
}
