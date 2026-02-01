<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\UserHasToken;
use Carbon\Carbon;

class WebController extends Controller
{
   
    
    public function index()
    {
       
        return view('finished');
    }
    
    

    public function purchaseSuccess(Request $request)
    {
        $msisdn = $request->input('msisdn');
        $tokenNo = UserHasToken::where('msisdn', $msisdn)
            ->first();
        $ticketNo = Ticket::where('id', $tokenNo->last_ticket_id)
            ->first()
            ->ticket_no;
        return view('purchase-success', compact('msisdn', 'tokenNo', 'ticketNo'));
    }

    public function downloadTicket()
    {
        return view('download-ticket');
    }

    public function checkTicket($msisdn, $token)
    {
        
        if($msisdn && $token){
            return redirect()->route('ticket.download', ['msisdn' => $msisdn, 'user_id' => $token]); 
        }else{
            return redirect()->route('ticket.download');
        }
       
    }
}
