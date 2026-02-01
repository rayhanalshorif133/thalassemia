<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {


        // pass
        // $pass = Hash::make('2l6eM?"l~4[W');

        $todayCount = Payment::where('status', 1)->whereDate('date', Carbon::today())->count();;
        $yesterdayCount = Payment::where('status', 1)->whereDate('date', Carbon::yesterday())->count();
        $totalSold = Payment::where('status', 1)->count();


        // chart
        $startDate = Carbon::parse('2025-12-01 00:00:00.0');
        $endDate = Carbon::today()->endOfDay();

        $salesData = Payment::whereBetween('date', [$startDate, $endDate])
            ->selectRaw('DATE(date) as date, count(*) as count')
            ->groupByRaw('DATE(date)')
            ->orderBy('date', 'ASC')
            ->where('status', 1)
            ->get();

        $labels = [];
        $data = [];

        foreach ($salesData as $row) {
            $labels[] = Carbon::parse($row->date)->format('d M');

            $data[] = $row->count;
        }

        return view('home', compact('todayCount', 'yesterdayCount', 'totalSold', 'labels', 'data'));
    }
}
