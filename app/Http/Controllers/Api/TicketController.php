<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\UserHasToken;
use App\Models\Ticket;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class TicketController extends Controller
{
    public function getTicket(Request $request, $msisdn)
    {
        try {
            $ticket = Ticket::where('sold_status', 0)->inRandomOrder()->first();

            if (substr($msisdn, 0, 2) !== '88') {
                $msisdn = '88' . $msisdn;
            }

            $payment = new Payment;
            $payment->ticket_series_id = $ticket ? $ticket->ticket_series_id : null;
            $payment->ticket_no = $ticket ? $ticket->ticket_no : null;
            $payment->msisdn = $msisdn;
            $payment->amount = 20;
            $payment->pay_status = 1;
            $payment->date = $request->date_time ? $request->date_time : now();
            $payment->response_data = $request->all() ? json_encode($request->all()) : null;
            $payment->save();


            // update ticket sold status if ticket is found
            if ($ticket) {
                $ticket->reference_no = $payment->id;
                $ticket->sold_status = 1;
                $ticket->sold_date = now();
                $ticket->save();


                // Update or create UserHasToken record
                $token =  UserHasToken::updateOrCreate(
                    ['msisdn' => $msisdn],
                    [
                        'token' => $this->generateToken(),
                        'last_ticket_id' => $ticket->id,
                        'type' => 'purchase',
                        'expires_at' => now()->addDays(30),
                    ]
                );

                return response()->json([
                    'status' => 'success',
                    'pay_id' => $payment->id,
                    'ticket_no' => $ticket ? $ticket->ticket_no : null,
                    'token' => $token->token,
                    'message' => $ticket ? 'Successfully purchased ticket.' : 'No tickets available.',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred', 'error' => $e->getMessage()], 500);
        }
    }


    public function callbackTicket(Request $request)
    {
        if ($request->result == 'success') {

            // GET Tricket Number


            // Send SMS

            return redirect()->route('purchase.success', ['msisdn' => $request->msisdn, 'type' => 'success']);
        }

        return redirect('https://thalassemia.b2mwap.com/?type=failure');
    }

    // https://thalassemia.b2mwap.com/api/callback?result=success&msisdn=8801323174104
    public function callbackTicketTest(Request $request)
    {
        if ($request->result == 'success') {

            // GET Tricket Number


            // $ticket = $this->getTicket($request, $request->msisdn);
            // $ticket_no = $ticket->original['ticket_no'];
            // $token = $ticket->original['token'];
            // $pay_id = $ticket->original['pay_id'];
            // $msisdn = $request->msisdn;
            // $payment = Payment::find($pay_id);

            // /send-sms
            // $url = 'https://thalassemia.b2mwap.com/api/send-sms';

            // // Making the GET request
            // $response = Http::get($url, [
            //     'user_id' => $token,
            //     'ticket_no' => $ticket_no,
            //     'msisdn' => $msisdn,
            //     'acr' => $request->acr,
            // ]);

            // // Check if the request was successful
            // if ($response->successful()) {
            //     $payment->send_sms = 1;
            //     $payment->save();
            // } else {
            //     Log::error('Failed to send SMS to ' . $msisdn . '. Response: ' . $response->body());
            // }

            return redirect()->route('purchase.success', ['msisdn' => $request->msisdn, 'type' => 'success']);
        }

        return redirect('https://thalassemia.b2mwap.com/?type=failure');
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
            $userToken = UserHasToken::where('msisdn', 'LIKE', '%' . $msisdn . '%')
                ->where('token', $token)
                ->first();

            if (!$userToken) {
                return response()->json(['status' => 'error', 'message' => 'Invalid MSISDN or token.'], 404);
            }

            $tickets = Payment::select('ticket_no')
                ->where('msisdn', 'LIKE', '%' . $msisdn . '%')
                ->where('status', 1)
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

    public function checkticket($msisdn, $count, $date)
    {


        $ticketsCount = Payment::where('msisdn', 'LIKE', '%' . $msisdn . '%')->count();
        $remainingTickets = $count - $ticketsCount;
        for ($i = 0; $i < $remainingTickets; $i++) {
            $randomTime = sprintf("%02d:%02d:%02d", rand(0, 23), rand(0, 59), rand(0, 59));
            $dateTime = $date . " " . $randomTime;
            $request = new \Illuminate\Http\Request([
                'date_time' => $dateTime,
                'type' => 'Portal',
            ]);
            $this->getTicket($request, $msisdn);
            Log::info("Create Ticket : " . $msisdn);
        }
        return redirect()->route('reports.index', ['ticket_no_msisdn' => $msisdn]);
    }


    public function deletePaymentRecord($id)
    {
        try {
            $payment = Payment::find($id);
            if (!$payment) {
                return response()->json(['status' => 'error', 'message' => 'Payment record not found.'], 404);
            }

            $payment->status = 0;
            $payment->save();

            return response()->json(['status' => 'success', 'message' => 'Payment record deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred', 'error' => $e->getMessage()], 500);
        }
    }
}
