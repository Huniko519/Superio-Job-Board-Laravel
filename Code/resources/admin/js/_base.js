(function ($) {
    $('.main-menu .has-children .btn-toggle').on('click',function () {
        var p = $(this).closest('.has-children');
        if(p.hasClass('active')){
            p.removeClass('active');
        }else{
            p.siblings().removeClass('active');
            p.addClass('active');
        }
    });

    $('.btn-toggle-admin-menu,.backdrop-sidebar-mobile').on('click',function () {
       $('body').toggleClass('sidebar-toggled');
    });


})(jQuery);
