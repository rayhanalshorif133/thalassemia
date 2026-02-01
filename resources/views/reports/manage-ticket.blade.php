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
    <form action="{{ route('manage-ticket') }}" method="GET">
        <div class="row align-items-end g-2">
            <div class="col-md-3">
                <label class="form-label small text-muted">Search</label>
                <input type="text" id="put_msisdn" name="msisdn" class="form-control"
                    placeholder="🔍 Ticket or Msisdn No..." value="{{ request('msisdn') }}">
            </div>

            <div class="col-md-2">
                <label class="form-label d-none d-md-block">&nbsp;</label>
                <button type="submit" class="btn btn-primary w-100" style="border-radius: 8px;">
                    Find Tickets
                </button>
            </div>
            <div class="col-md-2">
                <label class="form-label d-none d-md-block">&nbsp;</label>
                <a href="{{ route('manage-ticket') }}" class="btn btn-danger w-100" style="border-radius: 8px;">
                    Reset
                </a>
            </div>
            <div class="col-md-2">
                <label class="form-label d-none d-md-block">&nbsp;</label>
                <a href="#" class="btn btn-success d-none w-100 showTicketBtn" style="border-radius: 8px;">
                    Show Tickets <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </form>
</div>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Manage Ticket Data</h4>

        <a href="#" class="btn btn-primary" id="setNewTicketURL">
            <i class="bi bi-plus-lg"></i> Create New Ticket
        </a>
    </div>
    <div class="table-responsive">
        <div class="row text-center mb-4">
            <div class="col-4">
                <div class="p-3 border rounded bg-white">
                    <small class="text-muted d-block text-uppercase">Total</small>
                    <strong id="total-tries" class="h4">0</strong>
                </div>
            </div>
            <div class="col-4">
                <div class="p-3 border rounded bg-white border-success">
                    <small class="text-success d-block text-uppercase">Success</small>
                    <strong id="total-success" class="h4 text-success">0</strong>
                </div>
            </div>
            <div class="col-4">
                <div class="p-3 border rounded bg-white border-danger">
                    <small class="text-danger d-block text-uppercase">Failed</small>
                    <strong id="total-failed" class="h4 text-danger">0</strong>
                </div>
            </div>
        </div>
        <table class="table table-bordered table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>MSISDN</th>
                    <th>Keyword</th>
                    <th>Amount</th>
                    <th>ACR Key</th>
                    <th>Date/Time</th>
                </tr>
            </thead>
            <tbody id="manageTicketTBody">

            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-between align-items-center my-4">
        <h4 class="mb-0">Transaction History (<span id="user_attempts">0</span> Attempts)</h4>
    </div>
    <div class="table-responsive">

        <table class="table table-bordered table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#sl</th>
                    <th>MSISDN</th>
                    <th>Reponse</th>
                    <th>Date/Time</th>
                    <th>ACR Key</th>
                </tr>
            </thead>
            <tbody id="payTicketTBody"></tbody>
        </table>
    </div>
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

    $("#put_msisdn").on('input', function() {
        const inputVal = $(this).val();
        const convertedVal = convertBanglaToEnglish(inputVal);
        $(this).val(convertedVal);
    });

    $(() => {
        // Get the current URL
        var currentUrl = window.location.href;
        var urlParams = new URLSearchParams(window.location.search);
        var msisdn = urlParams.get('msisdn');
        var totalSuccess = 0;
        var countOnDemandLogs = 0;
        var date = '';







        if (msisdn) {



            // showTicketBtn
            $(".showTicketBtn").removeClass("d-none");
            $(".showTicketBtn").attr("href", `/reports?ticket_no_msisdn=${msisdn}`);

            axios.get(`https://gpglobal.b2mwap.com/api/check-tmt-log?msisdn=${msisdn}`)
                .then(res => {
                    const {
                        status,
                        logs,
                        pay_logs
                    } = res.data;

                    if (status == true) {
                        var HTML = '';
                        logs.length > 0 && logs.map((item, index) => {
                            HTML += `
                                <tr><td>${index + 1}</td>
                                <td><span class="badge bg-primary py-1">${item.msisdn}</span></td>
                                <td>${item.keyword}</td>
                                <td>${item.amount}</td>
                                <td class="small text-truncate" style="max-width: 100px;">
                                ${item.acr_key}
                                </td>
                                <td>
                                    <div class="small">${item.opt_date}</div>
                                    <div class="text-secondary smaller">${item.opt_time}</div>
                                </td></tr>
                            `;
                            date = item.opt_date;
                        });
                        countOnDemandLogs = logs.length;
                        $("#manageTicketTBody").html(HTML);
                    }

                });

            axios.get(`https://gpglobal.b2mwap.com/api/check-tmt-log?status=pay&msisdn=${msisdn}`)
                .then(res => {
                    const {
                        pay_logs,
                        getRechargeLogs,
                        status
                    } = res.data;

                    if (status == true) {
                        var HTML = '';
                        var totalFailed = 0;
                        var counter = 0;
                        pay_logs.length > 0 && pay_logs.map((item, index) => {
                            const resData = JSON.parse(item.response);
                            counter += 1;
                            var payStatus = "Insufficient Balance";
                            if ("amountTransaction" in resData) {
                                payStatus = 'Success';
                                totalSuccess += 1;
                            } else if ("requestError" in resData) {
                                console.log(resData);
                                if (resData.requestError.policyException) {
                                    payStatus = resData.requestError?.policyException?.text;
                                } else {
                                    payStatus = resData.requestError?.serviceException?.text;
                                }
                                totalFailed += 1;
                            }
                            HTML += `
                                <tr><td>${counter}</td>
                                <td>${msisdn}</td>
                                <td>${payStatus}</td>
                                <td>
                                    <div class="small">${item.date}</div>
                                </td>
                                <td>
                                    <div class="small">${item.acr_key}</div>
                                </td>
                                </tr>
                            `;
                        });

                        getRechargeLogs.length > 0 && getRechargeLogs.map((item, index) => {
                            counter += 1;
                            var payStatus = "Insufficient Balance";
                            if (item.recharge_status == 'ok') {
                                payStatus = 'Success';
                                totalSuccess += 1;
                            } else {
                                payStatus = "Recharge Deny";
                                totalFailed += 1;
                            }
                            HTML += `
                                <tr><td>${counter}</td>
                                <td>${item.msisdn}</td>
                                <td>${payStatus}</td>
                                <td>
                                    <div class="small">${item.transaction_date}</div>
                                </td>
                                <td>
                                    <div class="small">${item.acr}®️</div>
                                </td>
                                </tr>
                            `;
                        });

                        $("#payTicketTBody").html(HTML);
                        $("#user_attempts").text(counter);
                        $("#total-tries").text(counter);
                        $("#total-success").text(totalSuccess);
                        $("#total-failed").text(totalFailed);

                        if (totalSuccess == countOnDemandLogs) {
                            $("#setNewTicketURL").attr("href",
                                `/api/check-ticket/${msisdn}/${countOnDemandLogs}/${date}`);

                            $("#setNewTicketURL").removeClass("btn-primary").addClass("btn-success");
                        }
                    }

                });
        }


        $("#put_msisdn").on('keyup', function(e) {
            // remove spaces
            let msisdn = $(this).val().replace(/\s+/g, '');
            $(this).val(msisdn);
        });


    });
</script>
@endsection