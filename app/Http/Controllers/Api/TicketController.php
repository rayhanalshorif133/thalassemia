<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\UserHasToken;
use App\Models\Ticket;
use Symfony\Component\HttpFoundation\Request;

class TicketController extends Controller
{
    public function getTicket(Request $request, $msisdn)
    {
        try {
            $ticket = Ticket::where('sold_status', 0)->inRandomOrder()->first();

            $payment = new Payment;
            $payment->ticket_series_id = $ticket ? $ticket->ticket_series_id : null;
            $payment->ticket_no = $ticket ? $ticket->ticket_no : null;
            $payment->msisdn = $msisdn;
            $payment->amount = 20;
            $payment->pay_status = 1;
            $payment->date = now();
            $payment->response_data = $request->all() ? json_encode($request->all()) : null;
            $payment->save();


            // update ticket sold status if ticket is found
            if ($ticket) {
                $ticket->reference_no = $payment->id;
                $ticket->sold_status = 1;
                $ticket->sold_date = now();
                $ticket->save();


                // Update or create UserHasToken record
                UserHasToken::updateOrCreate(
                    ['msisdn' => $msisdn],
                    [
                        'token' => $this->generateToken(),
                        'last_ticket_id' => $ticket->id,
                        'type' => 'purchase',
                        'expires_at' => now()->addDays(30),
                    ]
                );

            }

            return response()->json([
                'status' => 'success',
                'ticket_no' => $ticket ? $ticket->ticket_no : null,
                'message' => $ticket ? 'Successfully purchased ticket.' : 'No tickets available.',
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred', 'error' => $e->getMessage()], 500);
        }
    }


    public function callbackTicket(Request $request)
    {
        if ($request->result == 'success') {
            return redirect()->route('purchase.success', ['msisdn' => $request->msisdn, 'type' => 'success']);
        }

        return redirect()->route('landing', ['type' => 'failure']);
    }


    private function generateToken()
    {
        $token = bin2hex(random_bytes(5));

      

        $existingToken = UserHasToken::where('token', $token)->first();
        if ($existingToken) {
            return $this->generateToken();
        }
        return $token;
    }


    public function fetchTicket(Request $request, $msisdn, $token)
    {
        try {
            $userToken = UserHasToken::where('msisdn', $msisdn)
                ->where('token', $token)
                ->first();

            if (!$userToken) {
                return response()->json(['status' => 'error', 'message' => 'Invalid MSISDN or token.'], 404);
            }

            $tickets = Payment::select('ticket_no')
                ->where('msisdn', $msisdn)
                ->get();

            if (!$tickets || $tickets->isEmpty()) {
                return response()->json(['status' => 'error', 'message' => 'Ticket not found.'], 404);
            }

            return response()->json([
                'status' => 'success',
                'tickets' => $tickets,
                'token_no' => $userToken->token,
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred', 'error' => $e->getMessage()], 500);
        }
    }
}
