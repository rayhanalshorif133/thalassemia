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



    <!-- Tickets Table -->
    <div class="content-card">
        <div class="d-flex align-items-center mb-4">
            <select id="seriesFilter" class="form-control form-control-sm mr-2" style="width: 200px;">
                <option value="">Select Series (All)</option>
                <option value="1">KA</option>
                <option value="2">KHA</option>
                <option value="3">GA</option>
                <option value="4">GHA</option>
                <option value="5">UMA</option>
                <option value="6">CHA</option>
                <option value="7">CSA</option>
                <option value="8">JA</option>
                <option value="9">JHA</option>
                <option value="10">NYO</option>
            </select>

            <button class="btn btn-success btn-sm exportExcelBtn mx-3" data-type="sell">
                <i class="fas fa-file-excel"></i> Export Sell Ticket Report
            </button>

            <button class="btn btn-danger btn-sm exportExcelBtn mx-3" data-type="remain">
                <i class="fas fa-file-excel"></i> Export Remain Ticket Report
            </button>
        </div>



    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>
    <script>
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



            $(".exportExcelBtn").on("click", function() {

                $(this).text('Loading...');
                const type = $(this).data('type');


                const filterId = $('#seriesFilter').val();


                if (!filterId) {
                    alert('Please select a series to export the report.');
                    $('.exportExcelBtn').html(`<i class="fas fa-file-excel"></i> Export Excel`);
                    return;
                }

                const urlParams = new URLSearchParams(window.location.search);
                axios.get('/report-download', {
                        params: {
                            series: filterId,
                            type: type
                        }
                    })
                    .then(response => {
                        const data = response.data;

                        const exportData = [];
                        data.length > 0 && data.map((item, index) => {
                            if (type === 'sell') {
                                exportData.push({
                                    "#": index + 1,
                                    "Ticket No": item.ticket_no,
                                    "Msisdn": item.msisdn
                                });
                            } else {
                                exportData.push({
                                    "#": index + 1,
                                    "Ticket No": item.ticket_no,
                                });
                            }
                        });

                        var ws = XLSX.utils.json_to_sheet(exportData);
                        var wscols = [];
                        if (type === 'sell') {
                            wscols = [{
                                    wch: 5
                                },
                                {
                                    wch: 15
                                },
                                {
                                    wch: 15
                                }
                            ];

                        } else {
                            wscols = [{
                                    wch: 5
                                },
                                {
                                    wch: 15
                                }
                            ];
                        }


                        ws['!cols'] = wscols;

                        var wb = XLSX.utils.book_new();
                        XLSX.utils.book_append_sheet(wb, ws, "Ticket_Report");
                        var fileName = 'Remain_Ticket_Report.xlsx';
                        if (type === 'sell') {
                            fileName = 'Sell_Ticket_Report.xlsx';
                        }

                        // সিলেক্ট করা অপশনের টেক্সট পাওয়ার জন্য
                        var selectedText = $('#seriesFilter option:selected').text();

                        fileName = selectedText + '_' + fileName;

                        XLSX.writeFile(wb, fileName);

                        $('.exportExcelBtn').html(`<i class="fas fa-file-excel"></i> Export Excel`);
                    })
                    .catch(error => {
                        console.error(error);
                    });






            });
        });
    </script>
@endsection
