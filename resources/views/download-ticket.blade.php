<?php
$msisdn = '';
if (isset($_SERVER['HTTP_X_UP_CALLING_LINE_ID'])) {
    $msisdn = trim($_SERVER['HTTP_X_UP_CALLING_LINE_ID']);
} elseif (isset($_SERVER['HTTP_X_HTS_CLID'])) {
    $msisdn = trim($_SERVER['HTTP_X_HTS_CLID']);
} elseif (isset($_SERVER['HTTP_MSISDN'])) {
    $msisdn = trim($_SERVER['HTTP_MSISDN']);
} elseif (isset($_COOKIE['User-Identity-Forward-msisdn'])) {
    $msisdn = $_COOKIE['User-Identity-Forward-msisdn'];
} elseif (isset($_SERVER['HTTP_X_MSISDN'])) {
    $msisdn = $_SERVER['HTTP_X_MSISDN'];
}

$msisdn = substr($msisdn, 0, 13);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BTS Lottery 2025</title>
    <link rel="icon" type="image/png" href="images/favicon.png">
    <!-- Google Fonts for Bengali -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        .tooltip-container {
            position: relative;
            display: inline-block;
            cursor: pointer;
            margin-left: 5px;
        }

        .tooltip-text {
            visibility: hidden;
            width: 220px;
            background-color: #2d3748;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 8px;
            font-size: 13px;
            line-height: 1.4;
            position: absolute;
            z-index: 10;
            bottom: 135%;
            left: 50%;
            transform: translateX(-50%);

            opacity: 0;
            transition: opacity 0.3s;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .tooltip-text::after {
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: #2d3748 transparent transparent transparent;
        }

        .tooltip-container:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
        }
    </style>


</head>

<body>

    <div class="container">
        <!-- Banner Section -->
        <header class="banner-section">
            <div class="banner-placeholder">
                <img src="{{ asset('images/header_.png') }}" alt="BTS Lottery 2025 Banner" class="banner-img"
                    onerror="this.style.display='none'; document.querySelector('.banner-alt').style.display='block';">
                <div class="banner-alt" style="display:none; padding: 20px; background: #e0f7fa; text-align: center;">
                    <h1 style="color: #0288d1;">বিটিএস লটারি-২০২৫</h1>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="content-section">
            <div class="logo-container">
                <img src="{{ asset('images/logo.png') }}" alt="BTS Logo" class="logo"
                    onerror="this.src='https://via.placeholder.com/100x100?text=BTS+Logo'">
            </div>

            <div class="text-content">
                <h2 class="org-name-red">বাংলাদেশ থ্যালাসেমিয়া সমিতি (বিটিএস)</h2>
                <p class="mission-text">বাংলাদেশ থ্যালাসেমিয়া সমিতি হাসপাতাল নির্মাণের লক্ষ্যে</p>
                <h1 class="lottery-title">বিটিএস লটারি-২০২৫</h1>
                <p class="gov-approval">গণপ্রজাতন্ত্রী বাংলাদেশ সরকার অনুমোদিত</p>
                <p class="prize-info">৫০ লক্ষ টাকার ৯৩৫ টি পুরস্কার</p>
                <p class="price-info">মূল্য: ২০ টাকা</p>
            </div>



            <!-- Form Section -->
            <form id="lottery-form">
                <div class="form-group">
                    <label for="mobile">Mobile no input</label>
                    <input type="tel" id="mobile" value="<?= $msisdn ?>" name="mobile"
                        placeholder="88017XXXXXXXX" maxlength="13" required>

                    <div id="error-msg" style="color: red; display: none; margin-top: 5px;"></div>
                </div>

                <div class="form-group">
                    <label for="token_number">
                        Unique User ID
                        <span class="tooltip-container">
                            <i class="fa-solid fa-circle-question icon"></i>

                            <span class="tooltip-text">
                                এটি আপনার ইউনিক User ID নম্বর।<br>
                                <span style="font-size: 11px; opacity: 0.8;">
                                    এটি টিকিটের নিচে বাম দিকে লেখা আছে।
                                </span>
                            </span>
                        </span>
                    </label>
                    <input type="text" id="token_number" value="" name="token_number"
                        placeholder="Enter your unique user ID" required>

                    <div id="error-msg" style="color: red; display: none; margin-top: 5px;"></div>
                </div>
                <div class="form-group">
                    <a href="#" class="download-btn"
                        style="display: flex;
    align-items: center;
    justify-content: center;
    width: 92%;
    margin: 0 auto;
    padding: 14px 20px;
    background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    color: #ffffff;
    font-family: 'Hind Siliguri', sans-serif;
    font-size: 18px;
    font-weight: 600;
    text-decoration: none;
    border-radius: 50px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    transition: all 0.3s ease;
    border: 2px solid transparent;
    cursor: pointer;">Download
                        Your Ticket</a>
                </div>


                <a href="{{ route('landing') }}" class="purchase-btn"
                    style="width: 95%!important; text-decoration: none;">
                    <i class="fa-solid fa-ticket"></i> আরও টিকেট ক্রয় করুন
                </a>
            </form>






            <div class="prize-card">
                <div class="prize-header">
                    <h3>পুরস্কারের তালিকা</h3>
                </div>

                <div class="prize-grid">
                    <div class="prize-item">
                        <span class="prize-label">১ম পুরস্কার:</span> (১টি) ফ্ল্যাট/নগদ ৩০ লক্ষ টাকা
                    </div>
                    <div class="prize-item">
                        <span class="prize-label">২য় পুরস্কার:</span> (১টি) গাড়ি/৭ লক্ষ টাকা
                    </div>
                    <div class="prize-item">
                        <span class="prize-label">৩য় পুরস্কার:</span> (১টি) মোটরসাইকেল/১ লক্ষ ৫০ হাজার টাকা
                    </div>
                    <div class="prize-item">
                        <span class="prize-label">৪র্থ পুরস্কার:</span> (১টি) নগদ ৫০ হাজার টাকা
                    </div>
                    <div class="prize-item">
                        <span class="prize-label">৫ম পুরস্কার:</span> (১টি) নগদ ৩০ হাজার টাকা
                    </div>
                    <div class="prize-item">
                        <span class="prize-label">৬ষ্ঠ পুরস্কার:</span> (১০টি) প্রতিটি ৫ হাজার টাকা
                    </div>
                    <div class="prize-item">
                        <span class="prize-label">৭ম পুরস্কার:</span> (১০০টি) প্রতিটি ২ হাজার টাকা
                    </div>
                    <div class="prize-item">
                        <span class="prize-label">৮ম পুরস্কার:</span> (৮২০টি) প্রতিটি ১ হাজার টাকা
                    </div>
                </div>

                <div class="prize-footer">
                    <p class="total-text">সর্বমোট ৫০ লক্ষ টাকার ৯৩৫ টি পুরষ্কার</p>
                    <p class="draw-date">ড্র: ০৩ ফেব্রুয়ারি ২০২৬ ইং</p>
                </div>
            </div>


        </main>

        <footer>
            <p>Powered by</p>
            <h3>B2M Technologies Ltd</h3>
        </footer>
    </div>


    <div id="termsModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Terms & Conditions</h3>
                <span class="close-btn">&times;</span>
            </div>
            <div class="modal-body">
                <ul>
                    <li>অনুমোদিত ব্যাংক, প্রতিষ্ঠান ও এই পোর্টাল ব্যতীত অন্য কোনো মাধ্যম হতে টিকেট ক্রয় করলে ঐ টিকেটের
                        জন্য বাংলাদেশ থ্যালাসামিয়া সমিতি ও সংশ্লিষ্ট কর্তৃপক্ষ দায়ী থাকবে না।</li>
                    <li>ক্রয়কৃত লটারীর টিকেট নম্বর ও কনফার্মেশন কেবলমাত্র "BTS Lottery" আইডি থেকে এসএমএস এর মাধ্যমে
                        পাঠানো হবে।</li>
                    <li>নির্ধারিত তারিখে বাংলাদেশ থ্যালাসেমিয়া সমিতি কর্তৃপক্ষ ও বিশিষ্ট ব্যাক্তিদের উপস্থিতিতে ঢাকায়
                        ড্র অনুষ্ঠিত হবে।</li>
                    <li>লটারীর ড্র এর নির্ধারিত তারিখ ২৩ জানুয়ারী ২০২৬; বিজয়ীদের তালিকা সংবাদপত্রের মাধ্যমে প্রকাশ করা
                        হবে। সেই সাথে বর্তমান ওয়েবসাইটেও (thalassemia.b2mwap.com) বিজয়ীদের তালিকা প্রকাশ হবে।</li>
                    <li>ফলাফল প্রকাশের ৩০ দিনের মধ্যে বিজয়ীদের পুরষ্কারের জন্য নাম ঠিকানা, সত্যায়িত ছবি ও টিকেট
                        প্রাপ্তির এসএমএস সহ লিখিত দাবী কর্তৃপক্ষের নিকট দাখিল করতে হবে। অনলাইন টিকেটের ক্ষেত্রে
                        টিকেটহোল্ডারকে হেল্পলাইনে (8801725298711) অথবা cservice@b2m-tech.com এ যোগাযোগ করার জন্য অনুরোধ
                        জানানো হচ্ছে।</li>
                    <li>৬ষ্ঠ হতে ৮ম পুরস্কারের ক্ষেত্রে বিজয়ী নম্বর ক,খ,গ, ঘ,ঙ, চ, ছ, জ, ঝ, ঞ প্রত্যেক সিরিজের ক্ষেত্রে
                        প্রযোজ্য হবে।</li>
                    <li>এই লটারী সংক্রান্ত যে কোন বিষয়ে বাংলাদেশ থ্যালাসেমিয়া সমিতি কর্তৃপক্ষের সিদ্ধান্তই চূড়ান্ত
                        বলে বিবেচিত হবে।</li>
                </ul>

                <p style="margin-top:10px; font-size: 12px;font-weight:bold; color: #666;">
                    <span style="color: #fe0000f7;">***</span> এই লটারী সংক্রান্ত যে কোন বিষয়ে বাংলাদেশ থ্যালাসেমিয়া
                    সমিতি কর্তৃপক্ষের সিদ্ধান্তই চূড়ান্ত বলে বিবেচিত হবে।
                </p>
            </div>
        </div>
    </div>



    <div id="successModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Purchase Successful</h3>
                <span class="close-btn" onclick="modelCloseBtn()">&times;</span>
            </div>

            <div class="modal-body success-body">
                <div class="success-icon-container">
                    <div class="success-icon">
                        <i class="fas fa-check"></i>
                    </div>
                </div>

                <h2 class="success-title">অভিনন্দন! (Congratulations!)</h2>
                <p class="success-desc">
                    আপনার টিকেট ক্রয় সম্পন্ন হয়েছে। একটি কনফার্মেশন এসএমএস আপনার মোবাইলে পাঠানো হয়েছে।
                </p>
            </div>
        </div>
    </div>



    <div id="ticket-visual"
        style="position: absolute; left: -9999px; top: 0; width: 600px; height: 270px; padding: 10px; border: 2px solid #11998e;
           background-image: url('https://thalassemia.b2mwap.com/images/bg_ticket.jpeg');
           background-color: #fff; 
           background-repeat: no-repeat;
           background-position: center center;
           background-size: 100% 100%; 
           -webkit-print-color-adjust: exact;">
        <div
            style="text-align: right; padding: 15px 40px; background: transparent;font-size: 18px; font-weight: 600;letter-spacing: 5px; color: #2f2f2f;">
            <span id="ticket_no"></span>
        </div>
        <div
            style="position: relative; left:10px; bottom: -12rem; font-size: 12px; font-weight: 500; color: #000; background: transparent; padding: 0 20px;">
            <span id="token_no"></span>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>

    <script>
        $(document).ready(function() {



            const urlString = window.location.href;

            try {
                const url = new URL(urlString);
                const params = new URLSearchParams(url.search);

                const msisdn = params.get('msisdn'); // "8801323174104"
                const userId = params.get('user_id'); // "f897e94fbc"

                if (msisdn && userId) {
                    $("#mobile").val(msisdn);
                    $("#token_number").val(userId);
                    setTimeout(() => {
                        $('.download-btn').click();
                    }, 500);
                } else {
                    console.warn("URL parameters are missing!");
                }
            } catch (error) {
                console.error("Invalid URL:", error);
            }



            const {
                jsPDF
            } = window.jspdf;

            $('.download-btn').click(function(e) {
                e.preventDefault();



                const msisdn = $('#mobile').val().trim();
                const tokenNumber = $('#token_number').val().trim();

                axios.get(`/api/fetch-ticket/${msisdn}/${tokenNumber}`)
                    .then(function(response) {
                        if (response.data && response.data.status === 'success') {
                            generateAllTickets(msisdn,response.data.tickets, response.data.token_no);
                        } else {
                            alert('Invalid response from server.');
                        }
                    })
                    .catch(function(error) {
                        console.log(error);
                    });
            });


            async function generateAllTickets(msisdn, ticketList, tokenNo) {

                var element = document.getElementById("ticket-visual");
                var doc;
                var imgWidth = 210;
                var imgHeight = 0;

                for (let i = 0; i < ticketList.length; i++) {
                    document.getElementById("ticket_no").innerText = ticketList[i].ticket_no;
                    document.getElementById("token_no").innerText = "Unique User ID: " + tokenNo;

                    try {
                        var canvas = await html2canvas(element, {
                            scale: 0.8,
                            useCORS: true
                        });
                        var imgData = canvas.toDataURL('image/png', 0.5);

                        if (i === 0) {
                            imgHeight = canvas.height * imgWidth / canvas.width;

                            doc = new jsPDF('l', 'mm', [imgWidth, imgHeight]);
                        } else {
                            doc.addPage([imgWidth, imgHeight], 'l');
                        }

                        doc.addImage(imgData, 'PNG', 0, 0, imgWidth, imgHeight);

                    } catch (error) {
                        console.error("Canvas error on ticket: " + ticketNo, error);
                    }
                }

                doc.save(`BTS_Tickets_${msisdn}.pdf`);

                if (typeof btn !== 'undefined') {
                    btn.html(originalText);
                }
            }

        });
    </script>
</body>

</html>
