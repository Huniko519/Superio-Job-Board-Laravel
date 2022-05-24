jQuery(function ($) {
    "use strict"
    if (superio_gateways_twocheckout.twocheckout_publishable_key === '') {
        console.log("TwoCheckout: Publishable not found");
        return false;
    }

    $("#bravo_twocheckout_card_name,#bravo_twocheckout_card_number,#bravo_twocheckout_card_expiry_month,#bravo_twocheckout_card_expiry_year,#bravo_twocheckout_card_cvc").on('change',function () {
        $(".card_twocheckout_msg").html("");
        var request_now = true;
        if($("#bravo_twocheckout_card_name").val() === ""){
            request_now = false;
        }
        if($("#bravo_twocheckout_card_number").val() === ""){
            request_now = false;
        }
        if($("#bravo_twocheckout_card_expiry_month").val() === ""){
            request_now = false;
        }
        if($("#bravo_twocheckout_card_expiry_year").val() === ""){
            request_now = false;
        }
        if($("#bravo_twocheckout_card_cvc").val() === ""){
            request_now = false;
        }
        if(request_now){
            tokenRequest();
        }
    });

    var tokenRequest = function () {
        var name = $('#bravo_twocheckout_card_name').val();
        var card_number = $('#bravo_twocheckout_card_number').val();
        var card_cvc = $('#bravo_twocheckout_card_cvc').val();
        var expiry_month = $('#bravo_twocheckout_card_expiry_month').val();
        var expiry_year = $('#bravo_twocheckout_card_expiry_year').val();
        var args = {
            sellerId: superio_gateways_twocheckout.twocheckout_account_number,
            publishableKey: superio_gateways_twocheckout.twocheckout_publishable_key,
            ccNo: card_number,
            cvv: card_cvc,
            expMonth: expiry_month,
            expYear: expiry_year
        };
        TCO.requestToken(successCallback, errorCallback, args);
    };

    var successCallback = function (data) {
        $("#bravo_twocheckout_token").val(data.response.token.token);
        $(".card_twocheckout_msg").html("");
        console.log("TwoCheckout: Create success!");
    };

    var errorCallback = function (data) {
        $(".card_twocheckout_msg").html(data.errorMsg);
    };
});
