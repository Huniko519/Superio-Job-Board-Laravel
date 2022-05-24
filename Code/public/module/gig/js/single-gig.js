(function ($) {
    $('.bravo_form_book_gig .btn-add-cart').click(function () {

        var form = $(this).closest('.bravo_form_book_gig');
        var gig_id = form.find('input[name=gig_id]').val();

        form.find('.is_loading').removeClass('d-none');
        form.find('.msg').html("");
        $.ajax({
            url:superio.url+'/gig/buy/'+gig_id,
            data:form.serialize(),
            dataType:'json',
            type:'post',
            success:function(res){
                if(res.redirect){
                    window.location.href = res.redirect
                }
                if(res.errors && typeof res.errors == 'object')
                {
                    var html = '';
                    for(var i in res.errors){
                        html += '<div class="alert alert-danger">' + res.errors[i]+ '</div>';
                    }
                   form.find('.msg').html(html);
                }
                form.find('.is_loading').addClass('d-none');
            },
            error:function (e) {
                console.log(e);
                bravo_handle_error_response(e);
            }
        })
    })

    $(".bravo_form_book_gig .default-tabs .tab-btn").click(function () {
        var container = $(this).closest('.tab-buttons');
        container.find('input[type=radio]').prop('checked', false);
        $(this).find('input[type=radio]').prop('checked', true);

    });

    $(".bravo_form_book_gig .default-tabs .compare_packages").click(function () {
        $('html, body').animate({
            scrollTop: $(".gig-page-packages-table").offset().top - 150
        }, 2000);
    })


})(jQuery);
