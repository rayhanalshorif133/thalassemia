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
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-7296KN4JK7');
    </script>

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



                <div style="display: flex;justify-content: space-between;">
                    <label class="terms-box" style="margin-bottom:10px!important">
                        <input type="checkbox" checked id="termscheckbox" required>
                        <div class="terms-content terms-btn-style termsBtn">
                            <span>Terms & Conditions</span>
                        </div>
                    </label>
                    <label class="download-box">
                        <a href="{{ route('ticket.download') }}" class="download-your-ticket-btn">
                            <span>Download you Ticket</span> <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </label>
                </div>
                <div style="display: flex;">
                    <label class="terms-box" style="margin-left:-13px!important;flex-direction: column;">
                        <div class="terms-content terms-btn-style" style="margin-left: -94px;">
                            <i style="color: #000000;font-size: 14px;" class="fa-solid fa-headset"></i>
                            <span style="color: #000000;font-size: 14px;">Support:</span>
                            <span style="color: #05009f;font-size: 14px;">
                                <a href="tel:+8801701677479"
                                    style="color: inherit; text-decoration: none;">8801701677479 </a>
                                    বা 
                                    <a href="tel:+8801732701937"
                                    style="color: inherit; text-decoration: none;">8801732701937 </a>
                            </span>
                        </div>
                         <div class="terms-content terms-btn-style" style="margin-left: 5px;">
                            <i style="color: #05009f;font-size: 14px;" class="fa-solid fa-clock"></i>
                            <span style="color: #000000; font-size: 15px;">
                                রবিবার থেকে বৃহস্পতিবার (সকাল ৯:৩০ টা থেকে বিকাল ৫:৩০ টা)
                            </span>
                        </div>
                        <div class="terms-content terms-btn-style" style="margin-left: -11.8rem;">
                            <i style="color: #05009f;font-size: 14px;" class="fa-solid fa-envelope"></i>
                            <span style="color: #000000; font-size: 15px;">
                                <a href="mailto:cservice@b2m-tech.com" style="color: inherit; text-decoration: none;">
                                    cservice@b2m-tech.com
                                </a>
                            </span>
                        </div>
                       
                    </label>
                </div>

                <button type="submit" class="purchase-btn">
                    <i class="fa-solid fa-ticket"></i> ক্রয় করুন
                </button>
                <p style="color: #c31e26;text-align: center;font-weight: 700;">⏰ টিকেট ক্রয়ের শেষ দিন: ২৯ জানুয়ারি ২০২৬</p>
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
                    <p class="draw-date">ড্র: ৩ ফেব্রুয়ারি ২০২৬ ইং</p>
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
                    <li>অনুমোদিতব্যাংক, প্রতিষ্ঠান ও এই পোর্টাল ব্যতীত অন্য কোনো মাধ্যম হতে টিকেট ক্রয় করলে ঐটিকেটের
                        জন্য বাংলাদেশ থ্যালাসামিয়া সমিতি ওসংশ্লিষ্ট কর্তৃপক্ষ দায়ী থাকবে না।</li>
                    <li>ক্রয়কৃতলটারীর টিকেট নম্বর ওকনফার্মেশন কেবলমাত্র "GP DOB" আইডি থেকে এসএমএস এর মাধ্যমে পাঠানো
                        হবে।</li>
                    <li>SMS না পেলে আপনার মোবাইলের SMS এপ এর SPAM সেকশনে যাচাই করুন। অন্যথায় হেল্পলাইনে (8801701677479 বা 8801732701937)
                        অথবা cservice@b2m-tech.com এ যোগাযোগ করার জন্য অনুরোধ জানানো হচ্ছে।</li>
                    <li>নির্ধারিত তারিখে বাংলাদেশ থ্যালাসেমিয়া সমিতি কর্তৃপক্ষ ও বিশিষ্ট ব্যাক্তিদের উপস্থিতিতে ঢাকায়
                        ড্র অনুষ্ঠিত হবে।</li>
                    <li>লটারীর ড্র এর নির্ধারিততারিখ ৩ ফেব্রুয়ারি ২০২৬; বিজয়ীদের তালিকা সংবাদপত্রের মাধ্যমে প্রকাশ করা
                        হবে। সেই সাথে বর্তমান ওয়েবসাইটেও (thalassemia.b2mwap.com) বিজয়ীদেরতালিকা প্রকাশ হবে।</li>
                    <li>ফলাফল প্রকাশের৩০ দিনের মধ্যে বিজয়ীদের পুরষ্কারের জন্য নাম ঠিকানা, সত্যায়িত ছবি ওটিকেট
                        প্রাপ্তির এসএমএস সহ লিখিত দাবী কর্তৃপক্ষের নিকট দাখিল করতে হবে। অনলাইন টিকেটের ক্ষেত্রে
                        টিকেটহোল্ডারকে হেল্পলাইনে (8801701677479 বা 8801732701937) অথবা cservice@b2m-tech.com এ যোগাযোগ করার জন্য অনুরোধ
                        জানানো হচ্ছে।</li>
                    <li>৬ষ্ঠ হতে ৮ম পুরস্কারেরক্ষেত্রে বিজয়ী নম্বর ক,খ,গ, ঘ,ঙ, চ, ছ, জ, ঝ, ঞপ্রত্যেক সিরিজের ক্ষেত্রে
                        প্রযোজ্য হবে।</li>
                    <li>এই লটারী সংক্রান্তযে কোন বিষয়ে বাংলাদেশ থ্যালাসেমিয়া সমিতি কর্তৃপক্ষের সিদ্ধান্তই চূড়ান্ত বলে
                        বিবেচিত হবে।</li>
                    <li>
                        এই মোবাইল লটারি ক্রয় প্রক্রিয়ায় গ্রামীনফোন শুধুমাত্র পেমেন্টপার্টনাররা হিসেবে বিদ্যমান, লটারি
                        সংক্রান্ত সকল কার্যক্রম—যেমনটিকিট যাচাই, টিকিট সরবরাহ, পুরস্কার যাচাই ও পুরস্কার
                        বিতরণ—সম্পূর্ণরূপে লটারি প্রদানকারী প্রতিষ্ঠান থ্যালাসেমিয়া সমিতি কর্তৃক পরিচালিত হয়।
                    </li>
                    <li>
                        লটারি ড্র সম্পন্ন হওয়ার পর বাংলাদেশ থ্যালাসেমিয়া সমিতি (বিটিএস)-এর ওয়েবসাইটে লটারির ফলাফল প্রকাশ
                        করা হবে এবং পরদিন ইত্তেফাক ও সমকাল পত্রিকায় তা প্রকাশিত হবে।
                    </li>

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
    <div id="failedModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Purchase Failed</h3>
                <span class="close-btn" onclick="failedModelCloseBtn()">&times;</span>
            </div>

            <div class="modal-body failed-body">
                <div class="failed-icon-container">
                    <div class="failed-icon">
                        <i class="fas fa-times"></i>
                    </div>
                </div>

                <h2 class="failed-title">দুঃখিত! (Sorry!)</h2>
                <p class="failed-desc">
                    আপনার টিকেট ক্রয় সম্পন্ন হয়নি। দয়া করে কিছুক্ষণ পর আবার চেষ্টা করুন।
                </p>

                <button class="retry-btn" onclick="failedModelCloseBtn()">আবার চেষ্টা করুন</button>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
