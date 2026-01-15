@extends('layouts.admin')

@section('title', 'Tickets')

@section('styles')
    <style>
        .search-box {
            background: white;
            border-radius: 10px;
            padding: 15px 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
        }

        .search-box input,
        .search-box select {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 10px 15px;
        }

        .btn-add {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 8px;
            padding: 10px 25px;
            color: white;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .btn-upload {
            background: #10b981;
            border: none;
            border-radius: 8px;
            padding: 10px 25px;
            color: white;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-upload:hover {
            background: #059669;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(16, 185, 129, 0.4);
            color: white;
        }

        .btn-export {
            background: #f59e0b;
            border: none;
            border-radius: 8px;
            padding: 10px 25px;
            color: white;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-export:hover {
            background: #d97706;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(245, 158, 11, 0.4);
            color: white;
        }

        .table thead th {
            background: #f8f9fa;
            border: none;
            padding: 15px;
            font-weight: 600;
            color: #2d3748;
            font-size: 14px;
        }

        .table tbody td {
            padding: 15px;
            border-top: 1px solid #e2e8f0;
            font-size: 14px;
            color: #4a5568;
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background: #f8f9fa;
        }

        .btn-action {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            border: none;
            transition: all 0.3s;
            margin: 0 2px;
        }

        .btn-view {
            background: #e6f2ff;
            color: #667eea;
        }

        .btn-view:hover {
            background: #667eea;
            color: white;
        }

        .btn-edit {
            background: #fff4e6;
            color: #f59e0b;
        }

        .btn-edit:hover {
            background: #f59e0b;
            color: white;
        }

        .btn-delete {
            background: #ffe6e6;
            color: #ef4444;
        }

        .btn-delete:hover {
            background: #ef4444;
            color: white;
        }

        nav svg {
            width: 16px !important;
            height: 16px !important;
        }

        nav a svg,
        nav span svg {
            display: block;
        }

        nav a[rel="next"],
        nav span[aria-disabled="true"] span {
            padding: 6px 8px !important;
        }
    </style>
@endsection

@section('content')
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Reports</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h2>Reports</h2>
                <p>Manage all payments record</p>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('errors') && is_array(session('errors')) && count(session('errors')) > 0)
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Some errors occurred:</strong>
            <ul class="mb-0 mt-2">
                @foreach (session('errors') as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Search & Filter -->
    <div class="search-box">
        <form action="{{ route('reports.index') }}" method="GET">
            <div class="row align-items-end g-2">
                <div class="col-md-3">
                    <label class="form-label small text-muted">Search</label>
                    <input type="text" name="ticket_no_msisdn" class="form-control"
                        placeholder="🔍 Ticket or Msisdn No..." value="{{ request('ticket_no_msisdn') }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label small text-muted" for="start_date">From Date</label>
                    <input type="date" name="start_date" id="start_date" class="form-control"
                        value="{{ request('start_date') }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label small text-muted" for="to_date">To Date</label>
                    <input type="date" name="end_date" id="to_date" class="form-control"
                        value="{{ request('end_date') }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label d-none d-md-block">&nbsp;</label>
                    <button type="submit" class="btn btn-primary w-100" style="border-radius: 8px;">
                        Filter Results
                    </button>
                </div>
                <div class="col-md-2">
                    <label class="form-label d-none d-md-block">&nbsp;</label>
                    <a href="{{ route('reports.index') }}" class="btn btn-danger w-100" style="border-radius: 8px;">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Tickets Table -->
    <div class="content-card">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5>Payment Records ({{ $payments->total() }})</h5>
            <button class="btn btn-success btn-sm exportExcelBtn">
                <i class="fas fa-file-excel"></i> Export Excel
            </button>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Ticket No</th>
                        <th>Msisdn</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $item)
                        <tr>
                            <td>{{ $payments->firstItem() + $loop->index }}</td>
                            <td><strong>{{ $item->ticket_no }}</strong></td>
                            <td>{{ $item->msisdn }}</td>
                            <td>{{ number_format($item->amount, 2) }}</td>
                            <td>
                                {{ $item->created_at ? $item->created_at->format('d M, Y') : '-' }}
                            </td>
                            <td>
                                <a target="_blank" class="btn btn-primary btn-sm"
                                    href="{{ route('ticket.download', ['msisdn' => $item->msisdn, 'user_id' => $item->userID($item->msisdn)]) }}">
                                    Download
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <p class="text-muted mb-0">No Records Found.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($payments->hasPages())
            <div class="mt-4">
                {{ $payments->links() }}
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>
    <script>
        $(() => {
            $("#start_date").on('change', function() {
                const startDate = $(this).val();
                $("#to_date").val(startDate);
            });


            $(".exportExcelBtn").on("click", function() {

                $(this).text('Loading...')

                const urlParams = new URLSearchParams(window.location.search);
                axios.get('/reports', {
                        params: {
                            ticket_no_msisdn: urlParams.get('ticket_no_msisdn'), // Gets value or null
                            start_date: urlParams.get('start_date'),
                            end_date: urlParams.get('end_date'),
                            fetch: true
                        }
                    })
                    .then(response => {
                        const data = response.data;
                        const exportData = [];
                        data.length > 0 && data.map((item, index) => {

                            exportData.push({
                                "#": index + 1,
                                "Ticket No": item.ticket_no,
                                "Msisdn": item.msisdn,
                                "Amount": item.amount,
                                "Date": moment(item.date).format('LL')
                            });
                        });

                        var ws = XLSX.utils.json_to_sheet(exportData);
                        var wscols = [{
                                wch: 5
                            },
                            {
                                wch: 15
                            },
                            {
                                wch: 15
                            },
                            {
                                wch: 10
                            },
                            {
                                wch: 15
                            }
                        ];
                        ws['!cols'] = wscols;

                        var wb = XLSX.utils.book_new();
                        XLSX.utils.book_append_sheet(wb, ws, "Ticket_Report");

                        XLSX.writeFile(wb, "Ticket_Sales_Data.xlsx");

                        $('.exportExcelBtn').html(`<i class="fas fa-file-excel"></i> Export Excel`);
                    })
                    .catch(error => {
                        console.error(error);
                    });






            });
        });
    </script>
@endsection
