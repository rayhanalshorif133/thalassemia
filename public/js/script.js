const modelCloseBtn = () => {
    const successModal = document.getElementById('successModal');
    successModal.style.display = 'none';
    reSetURLParams();
};


const failedModelCloseBtn = () => {
    const failedModal = document.getElementById('failedModal');
    failedModal.style.display = 'none';
    reSetURLParams();
};


const reSetURLParams = () => {
    const url = new URL(window.location);
    url.searchParams.delete('type');
    window.history.pushState({}, '', url);
};

window.addEventListener('load', function () {
    var currentUrl = window.location.href;
    if (currentUrl.includes("/public/")) {
        var newUrl = currentUrl.replace("/public/", "/");
        window.history.replaceState(null, '', newUrl);
    }
});

$(document).ready(function () {





    $('#mobile').on('keyup', function () {
        $(".purchase-btn").prop('disabled', false);

        var mobilePattern = /^8801[37][0-9]{8}$/;
        var mobile = $(this).val();

        if (mobile.startsWith('01')) {
            mobile = '88' + mobile;
            $(this).val(mobile);
        }

        if (!mobilePattern.test(mobile)) {
            $(".purchase-btn").prop('disabled', true);
            $('#error-msg').text('Please enter a valid GP number starting with 88017 or 88013.').show();
        } else {
            $('#error-msg').hide();
        }
    });


    var successModal = $('#successModal');
    var failedModal = $('#failedModal');
    var modal = $('#termsModal');
    // Select the link inside the label
    var triggerBtn = $('.termsBtn');
    var closeBtn = $('.close-btn');

    // 1. Open Modal when "Terms & Condition" link is clicked
    triggerBtn.on('click', function (e) {
        e.preventDefault(); // Stop page from jumping or reloading
        modal.css('display', 'flex'); // Flex centers it due to CSS settings
    });

    // 2. Close Modal when 'x' is clicked
    closeBtn.on('click', function () {
        modal.fadeOut(200);
    });

    // 3. Close Modal when clicking outside the modal content
    $(window).on('click', function (e) {
        if ($(e.target).is(modal)) {
            modal.fadeOut(200);
        }

        if ($(e.target).is(successModal)) {

            const url = new URL(window.location);
            url.searchParams.delete('type');
            window.history.pushState({}, '', url);
            successModal.fadeOut(200);
        }


        if ($(e.target).is(failedModal)) {

            const url = new URL(window.location);
            url.searchParams.delete('type');
            window.history.pushState({}, '', url);
            failedModal.fadeOut(200);
        }
    });

    // Optional: Close on ESC key press
    $(document).on('keydown', function (e) {
        if (e.key === "Escape") {
            modal.fadeOut(200);
            successModal.fadeOut(200);
        }
    });

});

document.addEventListener("DOMContentLoaded", function () {
    // 1. Get the URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    const type = urlParams.get('type');
    const ticketNo = urlParams.get('ticket_no');

    if (type === 'success') {
        const successModal = document.getElementById('successModal');

        if (ticketNo) {
            const ticketDisplay = document.getElementById('dynamic-ticket-number');
            if (ticketDisplay) {
                ticketDisplay.textContent = decodeURIComponent(ticketNo);
            }
        }

        // 4. Show the modal
        if (successModal) {
            successModal.style.display = 'flex';
        }
    }

    if (type === 'failure') {
        const failedModal = document.getElementById('failedModal');
        if (failedModal) {
            failedModal.style.display = 'flex';
        }
    }
});


$(document).ready(function () {
    $('#lottery-form').on('submit', function (e) {
        e.preventDefault();

        var mobile = $('#mobile').val();

        var gpRegex = /^8801[37][0-9]{8}$/;

        if (mobile == '') {
            alert('Please enter a mobile number.');
            e.preventDefault();
            return;
        }

        if (!gpRegex.test(mobile)) {
            $(".purchase-btn").prop('disabled', true);
            $('#error-msg').text('Invalid Number! Format must be 88017... or 88013...').show();
            e.preventDefault(); // Stop form from submitting
        } else {
            window.location.href = 'https://gpglobal.b2mwap.com/api/subscription?keyword=TMT&msisdn=' + mobile;
        }
    });


});
