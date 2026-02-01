<?php

use App\Http\Controllers\Api\TicketController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;


// Route::get('/get-ticket/{msisdn}', [TicketController::class, 'getTicket']);
Route::get('/callback', [TicketController::class, 'callbackTicketTest']);
Route::get('/delete-payment-record/{id}', [TicketController::class, 'deletePaymentRecord']);
// Route::get('/callback-test', [TicketController::class, 'callbackTicketTest']);

Route::get('/fetch-ticket/{msisdn}/{token}', [TicketController::class, 'fetchTicket']);



Route::get('/check-ticket/{msisdn}/{count}/{date}', [TicketController::class, 'checkticket']);



Route::get('/proxy-charge-logs', function (Request $request) {
    $date = $request->query('date');


    // Laravel makes the request to the external server
    $response = Http::get("https://gpglobal.b2mwap.com/log/on-demand-charge-number", [
        'start_date' => $date,
        'end_date'   => $date,
    ]);

    return $response->json();
});

Route::get('/proxy-charge-logs-number', function (Request $request) {

    // Laravel makes the request to the external server
    $response = Http::get("https://gpglobal.b2mwap.com/log/on-demand-charge-number", [
        'msisdn' => $request->query('msisdn'),
        'type' => 'msisdn',
        'opt_date' => $request->query('opt_date'),
        'setpay' => $request->query('setpay'),
    ]);

    return $response->json();
});

Route::get('/proxy-charge-logs-date-change', function (Request $request) {

    // Laravel makes the request to the external server
    $response = Http::get("https://gpglobal.b2mwap.com/log/on-demand-charge-number", [
        'id' => $request->query('id'),
        'date' => $request->query('date'),
        'type' => 'change-date',
    ]);

    return $response->json();
});


Route::get('/send-sms', function (Request $request) {

    // Laravel makes the request to the external server
    $response = Http::get("https://gpglobal.b2mwap.com/api/partner/send-sms", [
        'msisdn' => $request->query('msisdn'),
        'ticket_no' => $request->query('ticket_no'),
        'user_id' => $request->query('user_id'),
        'acr' => $request->query('acr'),
    ]);

    return $response->json();
});
