<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title id="setTitle">Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>
    <p>
        <span class="h5">14 - 2,839 ** </span>
        <span class="h5">15 - 3,845 ** </span>
        <span class="h5">16 - 3,281 ** </span>
        <span class="h5">17 - 1,350 ** </span>
    </p>
    <button class="btn btn-danger getInfoByMsisdn btn-sm py-1 px-3">GET Info Based On Msisdn
        <span id="reqCounterMsisdn"></span>
    </button>
    <button class="btn btn-primary get_charge_number btn-sm py-1 px-3">GET Charged Number</button>
    <button class="btn btn-info setZeroBtn btn-sm py-1 px-3">Set Zero</button>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">
                    msisdn (Thala) ({{ count($pays) }}) <br>
                    <span>Count:::{{ $totalCount }}</span>
                </th>
                <th scope="col">msisdn (GP Global) (<span id="gp_count"></span>) <br> Count:::<span
                        id="total_gp_count"></span></th>
            </tr>
        </thead>
        <tbody class="dataTableBody">
            @foreach ($pays as $index => $item)
                <tr>
                    <th scope="row">{{ $index + 1 }}</th>
                    <td>
                        <span id="thala_{{ $item['msisdn'] }}">
                            {{ $item['msisdn'] }}

                        </span> -
                        <span id="thala_count_{{ $item['msisdn'] }}">{{ $item['count'] }}</span>
                        <span id="thala_date_{{ $item['msisdn'] }}">Loading</span>
                        <a href="https://thalassemia.b2mwap.com/manage-ticket?msisdn={{ $item['msisdn'] }}"
                            target="_blank">
                            View Report
                        </a>
                    </td>
                    <td class="gp_number">0</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">msisdn (GP Global)</th>
                <th scope="col">OP Date</th>
                <th scope="col">ACR Key</th>
            </tr>
        </thead>
        <tbody class="dataTableBodyOnlyOnDemand"></tbody>
    </table>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/axios-minified@1.0.7/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script>
        var GPCounter = 0;

        $(() => {
            const curlUrlParams = new URLSearchParams(window.location.search);
            const targetDate = curlUrlParams.get('date');

            $('#setTitle').text(`${targetDate}`);
        });


        $(".setZeroBtn").on('click', function() {
            const _this = $(this);
            $(_this).text('Processing...');
            axios.get(`/api/proxy-charge-logs-number?setpay=1`)
                .then((res) => {
                    $(_this).text('All Set to Zero');

                    setTimeout(() => {
                        $(_this).text('Set Zero');
                    }, 2000);
                });
        });




        async function processNumbers() {
            let rows = $(".dataTableBody tr").toArray(); // Sob row ke array-te niye nilam
            let totalRequests = rows.length;
            let batchSize = 20; // Ekshathe koita request pathate chan (e.g., 10-20 ti safe)

            $("#reqCounterMsisdn").text(`Request Processing: ${totalRequests}`);
            const urlParams = new URLSearchParams(window.location.search);
            const targetDate = urlParams.get('date');
            $('#setTitle').text(`${targetDate} - ${totalRequests}`);

            for (let i = 0; i < rows.length; i += batchSize) {
                // Ekta batch slice kora holo
                const batch = rows.slice(i, i + batchSize);

                // Batch-er sob request eksathe start hobe
                const batchPromises = batch.map(async (row) => {
                    let msisdn = $(row).find("span:first").text().trim();

                    try {
                        const res = await axios.get(`/api/proxy-charge-logs-number?msisdn=${msisdn}`);
                        let htmlContent = '<br>';
                        const data = res.data.data;
                        let targetDateCount = 0;
                        const thala_count = $(`#thala_count_${msisdn}`).text();

                        if (data && data.length > 0) {
                            data.forEach((dateItem) => {
                                if (dateItem.opt_date === targetDate) {
                                    targetDateCount++;
                                }

                                htmlContent += `
                                <span>Total:${targetDateCount}</span> <br>
                            <span class="badge text-bg-success"> 
                                <span>${dateItem.opt_date}</span> 
                                <button data-id="${dateItem.id}" class="changeBtn" type="button">OK</button>
                                <button data-msisdn="${msisdn}" data-date="${dateItem.opt_date}" class="changePayDateBtn" type="button">OK Pay</button>
                            </span><br>`;


                            });
                            if (parseInt(thala_count) == parseInt(targetDateCount)) {
                                $(`#thala_${msisdn}`).closest('tr').find('.gp_number').html(
                                    `${msisdn}-${targetDateCount}- Same`);
                                $(`#thala_${msisdn}`).closest('tr').addClass('d-none');
                            } else {
                                $(`#thala_${msisdn}`).closest('tr').find('.gp_number').text(msisdn + '-' +
                                    targetDateCount + '- Not Same');
                            }


                        }

                        $(`#thala_date_${msisdn}`).html(htmlContent);

                        // Counter update
                        totalRequests--;
                        $("#reqCounterMsisdn").text(`Request Processing: ${totalRequests}`);
                        $('#setTitle').text(`${targetDate} - ${totalRequests}`);
                    } catch (error) {
                        console.error(`Error for ${msisdn}:`, error);
                    }
                });

                // Current batch sesh na houya porjonto porer batch-e jabena
                await Promise.all(batchPromises);

                // Target server-er opor chap komate 200ms pause (Optional)
                // await new Promise(res => setTimeout(res, 200));
            }

            $("#reqCounterMsisdn").text('Done');
            $('#setTitle').text(`${targetDate} - Done`);
        }


        $(document).on('click', '.getInfoByMsisdn', function() {
            var GETREQLen = $(".dataTableBody tr").length;
            $("#reqCounterMsisdn").text(`Request Processing: ${GETREQLen}`);
            processNumbers();

        });





        $(document).on('click', '.changeBtn', function() {
            let idAlt = $(this).attr('data-id');
            const _this = $(this);
            axios.get(`/api/proxy-charge-logs-date-change?id=${idAlt}&date=2026-01-14`).then((res) => {
                const data = res.data.data;
                const UpdateDate = data.opt_date;
                $(_this).parent().find('span').text(UpdateDate);

            });
        });


        $(document).on('click', '.changePayDateBtn', function() {
            let msisdn = $(this).attr('data-msisdn');
            let change_date = $(this).attr('data-date');
            const _this = $(this);
             const urlParams = new URLSearchParams(window.location.search);
            const targetDate = urlParams.get('date');
            axios.get(`/checking?msisdn=${msisdn}&date=${targetDate}&change_date=${change_date}`).then((res) => {
                console.log(res);
                $(_this).text('done');
            });
        });

        $(document).on('click', '.get_charge_number', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const opt_date = urlParams.get('date');
            axios.get(`/api/proxy-charge-logs-number?opt_date=${opt_date}`).then((res) => {
                const data = res.data.data;
                var HTML = '';
                var itemCount = 0;
                res.data.pays.length > 0 && res.data.pays.map((item) => {
                    itemCount++;
                    HTML += `<tr>
                        <td>${itemCount}</td>
                        <td>
                        <a href='https://thalassemia.b2mwap.com/manage-ticket?msisdn=${item.msisdn}' class="checkTicketBtn" target="_blank">
                            ${item.msisdn}
                        </a>
                        </td>
                        <td>${item.opt_date}</td>
                        <td>${item.acr_key}</td>
                    </tr>`;
                });

                if (res.data.pays.length == 0) {
                    HTML += `<tr>
                        <td colspan="4" text-align: center;>No Record</td>
                    </tr>`;
                }
                $(".dataTableBodyOnlyOnDemand").html(HTML);

            });
        });

        $(document).on('click', '.checkTicketBtn', function() {
            $(this).css('color', 'red');

        });
    </script>
</body>

</html>
