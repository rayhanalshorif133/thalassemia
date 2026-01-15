<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
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

        if($request->fetch){
            $data = $query->get(); 
            return response()->json($data);
        }

        $payments = $query->paginate(50);

        if ($request->start_date && $request->end_date) {
            $payments = $query->paginate($query->count());
        }

        return view('reports.index', compact('payments'));
    }

    
}
