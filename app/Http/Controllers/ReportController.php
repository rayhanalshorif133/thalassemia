<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {


        $query = Payment::query();

        if ($request->ticket_no_msisdn) {
            $query->where(function ($q) use ($request) {
                $q->where('msisdn', 'like', '%' . $request->ticket_no_msisdn . '%')
                    ->orWhere('ticket_no', 'like', '%' . $request->ticket_no_msisdn . '%');
            });
        }

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('date', [
                Carbon::parse($request->start_date)->startOfDay(),
                Carbon::parse($request->end_date)->endOfDay()
            ]);
        }

        $query->orderBy('created_at', 'desc');
        $query->Where('status', 1);


        if ($request->fetch && $request->type == 'remain') {
            // need to fetch remain tickets
            $allTickets = [];

            DB::table('tickets')
                ->whereNotIn('ticket_no', function ($subquery) {
                    $subquery->select('ticket_no')
                        ->from('payments')
                        ->where('status', 1);
                })
                ->select('ticket_no', 'created_at')
                ->orderBy('created_at') // Chunk use korle ordering thaka bhalo
                ->chunk(1000, function ($tickets) use (&$allTickets) {
                    foreach ($tickets as $ticket) {
                        $allTickets[] = $ticket;
                    }
                });

            return response()->json($allTickets);
        }

        if ($request->fetch) {
            $data = $query->get();
            return response()->json($data);
        }

        $payments = $query->paginate(50);

        if ($request->start_date && $request->end_date) {
            $payments = $query->paginate($query->count());
        }

        $user_id = '';
        if ($request->ticket_no_msisdn) {
            $user_id = DB::table('user_has_token')
                ->where('msisdn', 'like', '%' . $request->ticket_no_msisdn . '%')
                ->first();
        }

        return view('reports.index', compact('payments', 'user_id'));
    }

    public function manageTicket(Request $request)
    {
        return view('reports.manage-ticket');
    }

    public function checkingTicket(Request $request)
    {
        /* 
        
        */
        // 

        if ($request->change_date) {
            $payment = Payment::where('msisdn', 'like', '%' . $request->msisdn . '%')
                ->where('date', 'like', '%' . $request->date . '%')
                ->first();
            $payment->date = Carbon::parse($request->change_date)->format('Y-m-d H:i:s');
            $payment->save();
            return response()->json(['status' => 'Date changed successfully']);
        }

        $pays = Payment::whereDate('date', Carbon::parse($request->date)->format('Y-m-d'))
            ->where('status', 1)
            ->where('gp_status', 0)
            ->get()
            ->groupBy('msisdn')
            ->map(function ($group) {
                return [
                    'msisdn' => $group->first()->msisdn,
                    'count'  => $group->count(),
                ];
            })
            ->values();

        $totalCount = $pays->sum('count');
        // Pass 'pays' as a string to compact
        return view('reports.check-ticket', compact('pays', 'totalCount'));
    }


    public function reportDownload(Request $request)
    {

        if ($request->series && $request->type == 'sell') {
            $query = Payment::query();

            if ($request->series) {
                $query->where('ticket_series_id', $request->series);
            }

            $query->where('status', 1);
            $payments = $query->get();

            return response()->json($payments);
        }

        if ($request->series && $request->type == 'remain') {
            $allTickets = DB::table('tickets')
                ->where('ticket_series_id', $request->series)
                ->whereNotIn('ticket_no', function ($subquery) use ($request) {
                    $subquery->select('ticket_no')
                        ->from('payments')
                        ->where('status', 1)
                        ->where('ticket_series_id', $request->series);
                })
                ->select('ticket_no', 'created_at')
                ->orderBy('created_at')
                ->get(); // <--- This is the missing piece!

            return response()->json($allTickets);
        }

        return view('reports.report-download');
    }
}
