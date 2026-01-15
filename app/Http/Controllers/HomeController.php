<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

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

        // dd($pass);

        $todayCount = Payment::whereDate('date', Carbon::today())->count();;
        $yesterdayCount = Payment::whereDate('date', Carbon::yesterday())->count();
        $totalSold = Payment::count();


        // chart
    $startDate = Carbon::parse('2025-12-01 00:00:00.0');
    $endDate = Carbon::today()->endOfDay();

    $salesData = Payment::whereBetween('date', [$startDate, $endDate])
                ->selectRaw('DATE(date) as date, count(*) as count')
                ->groupByRaw('DATE(date)') // গ্রুপিং
                ->orderBy('date', 'ASC')   // ছোট থেকে বড় তারিখ অনুযায়ী সাজানো
                ->get();

    // ২. লেবেল এবং ডাটা অ্যারে প্রস্তুত করা
    $labels = [];
    $data = [];

    foreach ($salesData as $row) {
        // তারিখ ফরম্যাট (যেমন: 24 Dec)
        $labels[] = Carbon::parse($row->date)->format('d M'); 
        
        // ওই তারিখের কাউন্ট
        $data[] = $row->count;
    }

        return view('home', compact('todayCount', 'yesterdayCount', 'totalSold', 'labels', 'data'));
    }
}
