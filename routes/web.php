<?php

use App\Http\Controllers\TicketController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::get('clear', function () {
    Artisan::call('view:clear');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('optimize:clear');
    Artisan::call('config:cache');
    Artisan::call('optimize');
    Artisan::call('route:cache');
    return 'Clear';
});

Route::get('/', [WebController::class, 'index'])->name('landing');
Route::get('/finished', [WebController::class, 'finished'])->name('finished');
Route::get('/purchase-success', [WebController::class, 'purchaseSuccess'])->name('purchase.success');
Route::get('/download-ticket', [WebController::class, 'downloadTicket'])->name('ticket.download');
Route::get('/ps/{msisdn}/{token}', [WebController::class, 'checkTicket'])->name('ticket.check');


// Ticket CRUD routes (protected by auth middleware)
Route::middleware(['auth'])->group(function () {

    // CSV Upload routes
    Route::get('/tickets/upload', [TicketController::class, 'uploadForm'])->name('tickets.upload.form');
    Route::post('/tickets/upload', [TicketController::class, 'uploadCsv'])->name('tickets.upload.csv');
    
    // CSV Export route
    Route::get('/tickets/export', [TicketController::class, 'exportCsv'])->name('tickets.export');
    


    // Resource routes for CRUD
    Route::resource('tickets', TicketController::class);

    // Report routes
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/report-download', [ReportController::class, 'reportDownload'])->name('reports.download');

    Route::get('/manage-ticket', [ReportController::class, 'manageTicket'])->name('manage-ticket');

    Route::get('/checking',[ReportController::class, 'checkingTicket']);
});

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

