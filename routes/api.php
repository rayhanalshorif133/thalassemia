<?php

use App\Http\Controllers\Api\TicketController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/get-ticket/{msisdn}', [TicketController::class, 'getTicket']);
Route::get('/callback', [TicketController::class, 'callbackTicket']);

Route::get('/fetch-ticket/{msisdn}/{token}', [TicketController::class, 'fetchTicket']);