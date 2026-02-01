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

        #deleteNow {
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('reports.download') }}">Reports</a></li>
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
                <div class="col-md-2">
                    <label class="form-label small text-muted">Search</label>
                    <input type="text" id="msisdnInput" name="ticket_no_msisdn" class="form-control"
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
                    <button type="submit" class="btn btn-primary w-75" style="border-radius: 8px;">
                        Filter Results
                    </button>
                </div>
                <div class="col-md-2">
                    <label class="form-label d-none d-md-block">&nbsp;</label>
                    <a href="{{ route('reports.index') }}" class="btn btn-danger w-75" style="border-radius: 8px;">
                        Reset
                    </a>
                </div>
                <div class="col-md-2">
                    <label class="form-label d-none d-md-block">&nbsp;</label>
                    <a href="#" class="btn btn-info d-none w-75 showMTicketBtn" style="border-radius: 8px;">
                        M. Tickets <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Tickets Table -->
    <div class="content-card">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5>Payment Records ({{ $payments->total() }})</h5>
            <div>
                <button class="btn btn-success btn-sm exportExcelBtn">
                    <i class="fas fa-file-excel"></i> Export Excel
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <input type="hidden" id="acr" value="" />
            @if ($user_id)
                <input type="hidden" id="user_id" value="{{ $user_id->token }}" />
            @endif
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
                            <td><strong>{{ $item->ticket_no }}</strong>
                                <span id="{{ str_replace(' ', '_', $item->ticket_no) }}"
                                    class="badge bg-danger mx-1 send_sms d-none">Processing Failed</span>
                            </td>
                            <td>{{ $item->msisdn }}</td>
                            <td data-id="{{ $item->id }}" class="deleteNow">{{ number_format($item->amount, 2) }}</td>
                            <td>
                                {{ $item->date ? $item->date->format('d M, Y') : '-' }}
                            </td>
                            <td>
                                <a target="_blank" class="btn btn-primary btn-sm"
                                    href="{{ route('ticket.download', ['msisdn' => $item->msisdn, 'user_id' => $item->userID($item->msisdn)]) }}">
                                    Download
                                </a>
                                <button data-ticket_no="{{ $item->ticket_no }}" class="btn btn-info btn-sm d-none sendSMS">
                                    Send SMS
                                </button>
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
        function convertBanglaToEnglish(input) {
            const banglaNumbers = {
                '০': '0',
                '১': '1',
                '২': '2',
                '৩': '3',
                '৪': '4',
                '৫': '5',
                '৬': '6',
                '৭': '7',
                '৮': '8',
                '৯': '9'
            };

            return input.replace(/[০-৯]/g, function(digit) {
                return banglaNumbers[digit];
            });
        }

        $("#msisdnInput").on('input', function() {
            const inputVal = $(this).val();
            const convertedVal = convertBanglaToEnglish(inputVal);
            $(this).val(convertedVal);
        });

        $("#msisdnInput").on('keyup', function(e) {
            let msisdn = $(this).val().replace(/\s+/g, '');
            $(this).val(msisdn);
        });

        $(() => {
            $("#start_date").on('change', function() {
                const startDate = $(this).val();
                $("#to_date").val(startDate);
            });

            $(".deleteNow").on('click', function() {
                const id = $(this).data('id');

                axios.get(`/api/delete-payment-record/${id}`).then((res) => {
                    location.reload();
                });
                // if (confirm(`Are you sure you want to delete records?`)) {
                // }
            });

            const urlParams = new URLSearchParams(window.location.search);
            const hasMsisdn = urlParams.get('ticket_no_msisdn');

            const fetchSMSLogs = () => {
                axios.get(`https://gpglobal.b2mwap.com/api/check-tmt-log?msisdn=${hasMsisdn}&status=sms`)
                    .then(async (res) => {
                        var tickets = [];
                        await res.data.sms_logs.length > 0 && res.data.sms_logs.map((item) => {
                            const msg = item.message;
                            let ticketMatch = msg.match(/টিকেট নাম্বার:\s*([^,]+)/);

                            if (ticketMatch && ticketMatch[1]) {
                                let ticketNumber = ticketMatch[1].trim();
                                if (ticketNumber != 'Processing Failed') {
                                    ticketNumber = ticketNumber.replace(/\s+/g, '_');
                                    tickets.push(ticketNumber);
                                }
                            }
                        });


                        tickets.length > 0 && tickets.map((item) => {
                            $(`#${item}`).text("Send").removeClass('bg-danger').addClass(
                                'bg-success');
                            $(`#${item}`).closest('tr').find('.sendSMS')
                        });

                        if (res.data.acr) {
                            $('#acr').val(res.data.acr.customer_reference);
                            $('.sendSMS').removeClass('d-none');
                        }
                    });
            };

            if (hasMsisdn) {
                $(".send_sms").removeClass('d-none');
                $(".showMTicketBtn").removeClass('d-none');
                $(".showMTicketBtn").attr("href", `/manage-ticket?msisdn=${hasMsisdn}`);
                fetchSMSLogs();
            }


            $(".sendSMS").on('click', function() {
                $(this).removeClass('btn-info').addClass('btn-warning');
                $(this).text('Sending ...');
                const ticket_no = $(this).data('ticket_no');
                const acr = $('#acr').val();
                const user_id = $('#user_id').val();
                axios.get(
                        `/api/send-sms?acr=${acr}&msisdn=${hasMsisdn}&ticket_no=${ticket_no}&user_id=${user_id}`
                    )
                    .then((res) => {
                        console.log(res.data);
                        $(this).text('Success');
                        $(this).removeClass('btn-warning').addClass('btn-success');
                        fetchSMSLogs();

                        setTimeout(() => {
                            $(this).removeClass('btn-success').addClass('btn-info');
                            $(this).text('Send SMS');
                        }, 1000);
                    });
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

            $(".exportRemainTicketsBtn").on("click", function() {

                $(this).text('Loading...');


                axios.get('/reports', {
                        params: {
                            type: 'remain',
                            fetch: true
                        }
                    })
                    .then(response => {
                        const data = response.data;


                        console.log(data);

                        $(this).text('Export Remain Tickets');

                        return false;
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
