<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Ticket::with(['creator', 'updater']);

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('ticket_no', 'like', "%{$search}%")
                  ->orWhere('reference_no', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('sold_status', $request->status);
        }

        // Order by latest
        $query->orderBy('created_at', 'desc');

        $tickets = $query->paginate(20);

        return view('tickets.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tickets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ticket_no' => 'required|string|max:255|unique:tickets,ticket_no',
            'reference_no' => 'nullable|integer',
            'sold_status' => 'required|in:0,1',
            'sold_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $ticket = new Ticket();
        $ticket->ticket_no = $request->ticket_no;
        $ticket->reference_no = $request->reference_no;
        $ticket->sold_status = $request->sold_status;
        $ticket->sold_date = $request->sold_date;
        $ticket->created_by = Auth::id();
        $ticket->updated_by = Auth::id();
        $ticket->save();

        return redirect()->route('tickets.index')
            ->with('success', 'Ticket created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        $ticket->load(['creator', 'updater']);
        return view('tickets.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        return view('tickets.edit', compact('ticket'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        $validator = Validator::make($request->all(), [
            'ticket_no' => 'required|string|max:255|unique:tickets,ticket_no,' . $ticket->id,
            'reference_no' => 'nullable|integer',
            'sold_status' => 'required|in:0,1',
            'sold_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $ticket->ticket_no = $request->ticket_no;
        $ticket->reference_no = $request->reference_no;
        $ticket->sold_status = $request->sold_status;
        $ticket->sold_date = $request->sold_date;
        $ticket->updated_by = Auth::id();
        $ticket->save();

        return redirect()->route('tickets.index')
            ->with('success', 'Ticket updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        return redirect()->route('tickets.index')
            ->with('success', 'Ticket deleted successfully!');
    }

    /**
     * Show the CSV upload form.
     */
    public function uploadForm()
    {
        return view('tickets.upload');
    }

    /**
     * Process CSV upload.
     */
    public function uploadCsv(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $file = $request->file('csv_file');
        $path = $file->getRealPath();

        $csvData = array_map('str_getcsv', file($path));

        // Remove header row if exists
        $header = array_shift($csvData);

        $successCount = 0;
        $errorCount = 0;
        $errors = [];

        DB::beginTransaction();

        try {
            foreach ($csvData as $index => $row) {
                // Skip empty rows
                if (empty($row[0])) {
                    continue;
                }

                $ticketNo = trim($row[0]);

                // Check if ticket already exists
                if (Ticket::where('ticket_no', $ticketNo)->exists()) {
                    $errorCount++;
                    $errors[] = "Row " . ($index + 2) . ": Ticket {$ticketNo} already exists";
                    continue;
                }

                // Create ticket
                Ticket::create([
                    'ticket_no' => $ticketNo,
                    'reference_no' => null,
                    'sold_status' => 0,
                    'sold_date' => null,
                    'created_by' => Auth::id(),
                    'updated_by' => Auth::id(),
                ]);

                $successCount++;
            }

            DB::commit();

            $message = "CSV uploaded successfully! {$successCount} tickets imported.";
            if ($errorCount > 0) {
                $message .= " {$errorCount} tickets skipped due to errors.";
            }

            return redirect()->route('tickets.index')
                ->with('success', $message)
                ->with('errors', $errors);

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Error uploading CSV: ' . $e->getMessage());
        }
    }

    /**
     * Export tickets to CSV.
     */
    public function exportCsv()
    {
        $tickets = Ticket::all();

        $filename = 'tickets_' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($tickets) {
            $file = fopen('php://output', 'w');

            // Add headers
            fputcsv($file, ['Ticket No', 'Reference No', 'Status', 'Sold Date', 'Created At']);

            // Add data
            foreach ($tickets as $ticket) {
                fputcsv($file, [
                    $ticket->ticket_no,
                    $ticket->reference_no,
                    $ticket->status_label,
                    $ticket->sold_date ? $ticket->sold_date->format('Y-m-d H:i:s') : '',
                    $ticket->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
