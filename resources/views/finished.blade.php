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

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-7296KN4JK7"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-7296KN4JK7');
    </script>

    <style>
        .buy-button {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 6px 86px;
            min-width: 300px;
            margin: auto;
            border-radius: 12px;
            border: 1px solid #b8860b;
            background: linear-gradient(to bottom, #0056a4 0%, #003d73 100%);

            transition: transform 0.2s ease;
        }


        .icon {
            font-size: 20px;
            margin-right: 10px;
            color: #ffd700;
        }

        .text {
            color: white;
            font-size: 22px;
            font-weight: bold;
            font-family: 'Hind Siliguri', sans-serif;
        }

    </style>

</head>

<body>

    <div class="container">
        <!-- Banner Section -->
        <header class="banner-section">
            <div class="banner-placeholder">
                <!-- In a real scenario, this would be an img tag with the banner image -->
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
            </div>

            <p class="buy-button">
                <span class="icon">🎟️</span>
                <span class="text">ড্র : ৩ ফেব্রুয়ারি ২০২৬</span>
            </p>

            <p style="color: #c31e26;font-weight: 700;">⏰ টিকেট ক্রয়ের শেষ দিন: ২৯ জানুয়ারি ২০২৬</p>
            <p>ফলাফল জানতে চোখ রাখুন ৪ জানুয়ারি <br /> <span style="font-weight: 700;">সমকাল ও ইত্তেফাক পত্রিকায়</span>
            </p>
            <p>অথবা ভিজিট করুন <br />
                <a href="https://www.thalassaemiasamity.org/"
                    style="text-decoration: auto;font-size: 18px;font-weight: 600;color: #000;"
                    target="_blank">www.thalassaemiasamity.org</a>
            </p>


        </main>

        <footer>
            <p>Powered by</p>
            <h3>B2M Technologies Ltd</h3>
        </footer>
    </div>



    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
