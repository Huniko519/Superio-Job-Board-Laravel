(function ($) {
    $(document).on('click', '.bc-request-vision', function(event) {
        event.preventDefault();
        this.blur();
        $("#bc-request-revision-popup").modal({
            fadeDuration: 300,
            fadeDelay: 0.15
        });
    });

    $(document).on('click', '.bc-seller-delivery', function(event) {
        event.preventDefault();
        this.blur();
        $("#bc-delivery-popup").modal({
            fadeDuration: 300,
            fadeDelay: 0.15
        });
    });

    $(".accept-order").on("click", function (e) {
        if(!confirm($(this).attr('data-confirm'))){
            e.preventDefault();
        }
    });

})(jQuery);
