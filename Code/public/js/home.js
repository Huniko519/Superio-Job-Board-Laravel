jQuery(function ($) {
    "use strict"
    $.fn.bravoAutocomplete = function (options) {
        return this.each(function () {
            var $this = $(this);
            var main = $(this).closest(".smart-search");
            var textLoading = options.textLoading;
            main.append('<div class="bravo-autocomplete on-message"><div class="list-item"></div><div class="message">'+textLoading+'</div></div>');
            $(document).on("click.Bst", function(event){
                if (main.has(event.target).length === 0 && !main.is(event.target)) {
                    main.find('.bravo-autocomplete').removeClass('show');
                } else {
                    if (options.dataDefault.length > 0) {
                        main.find('.bravo-autocomplete').addClass('show');
                    }
                }
            });
            if (options.dataDefault.length > 0) {
                var items = '';
                for (var index in options.dataDefault) {
                    var item = options.dataDefault[index];
                    items += '<div class="item" data-id="' + item.id + '" data-text="' + item.title + '"> <i class="'+options.iconItem+'"></i> ' + item.title + ' </div>';
                }
                main.find('.bravo-autocomplete .list-item').html(items);
                main.find('.bravo-autocomplete').removeClass("on-message");
            }
            var requestTimeLimit;
            if(typeof options.url !='undefined' && options.url) {
                $this.on('keyup',function () {
                    main.find('.bravo-autocomplete').addClass("on-message");
                    main.find('.bravo-autocomplete .message').html(textLoading);
                    main.find('.child_id').val("");
                    var query = $(this).val();
                    clearTimeout(requestTimeLimit);
                    if (query.length === 0) {
                        if (options.dataDefault.length > 0) {
                            var items = '';
                            for (var index in options.dataDefault) {
                                var item = options.dataDefault[index];
                                items += '<div class="item" data-id="' + item.id + '" data-text="' + item.title + '"> <i class="' + options.iconItem + '"></i> ' + item.title + ' </div>';
                            }
                            main.find('.bravo-autocomplete .list-item').html(items);
                            main.find('.bravo-autocomplete').removeClass("on-message");
                        } else {
                            main.find('.bravo-autocomplete').removeClass('show');
                        }
                        return;
                    }
                    requestTimeLimit = setTimeout(function () {
                        $.ajax({
                            url: options.url,
                            data: {
                                search: query,
                            },
                            dataType: 'json',
                            type: 'get',
                            beforeSend: function () {
                            },
                            success: function (res) {
                                if (res.status === 1) {
                                    var items = '';
                                    for (var ix in res.data) {
                                        var item = res.data[ix];
                                        items += '<div class="item" data-id="' + item.id + '" data-text="' + item.title + '"> <i class="' + options.iconItem + '"></i> ' + get_highlight(item.title, query) + ' </div>';
                                    }
                                    main.find('.bravo-autocomplete .list-item').html(items);
                                    main.find('.bravo-autocomplete').removeClass("on-message");
                                }
                                if ( typeof res.message === undefined) {
                                    main.find('.bravo-autocomplete').addClass("on-message");
                                }else{
                                    main.find('.bravo-autocomplete .message').html(res.message);
                                }
                            }
                        })
                    }, 700);

                    function get_highlight(text, val) {
                        return text.replace(
                            new RegExp(val + '(?!([^<]+)?>)', 'gi'),
                            '<span class="h-line">$&</span>'
                        );
                    }

                    main.find('.bravo-autocomplete').addClass('show');
                });
            }
            main.find('.bravo-autocomplete').on('click','.item',function () {
                var id = $(this).attr('data-id'),
                    text = $(this).attr('data-text');
                if(id.length > 0 && text.length > 0){
                    text = text.replace(/-/g, "");
                    text = trimFunc(text,' ');
                    text = trimFunc(text,'-');
                    main.find('.parent_text').val(text).trigger("change");
                    main.find('.child_id').val(id).trigger("change");
                }else{
                    console.log("Cannot select!")
                }
                setTimeout(function () {
                    main.find('.bravo-autocomplete').removeClass('show');
                },100);
            });

            var trimFunc = function (s, c) {
                if (c === "]") c = "\\]";
                if (c === "\\") c = "\\\\";
                return s.replace(new RegExp(
                    "^[" + c + "]+|[" + c + "]+$", "g"
                ), "");
            }
        });
    };
});

jQuery(function ($) {
    "use strict"
    function parseErrorMessage(e){
        var html = '';
        if(e.responseJSON){
            if(e.responseJSON.errors){
                return Object.values(e.responseJSON.errors).join('<br>');
            }
        }
        return html;
    }
    $(".g-map-place").each(function () {
        var map = $(this).find('.map').attr('id');
        var searchInput =  $(this).find('input[name=map_place]');
        var latInput = $(this).find('input[name="map_lat"]');
        var lgnInput = $(this).find('input[name="map_lgn"]');
        new BravoMapEngine(map, {
            fitBounds: true,
            center: [ 51.505, -0.09],
            ready: function (engineMap) {
            engineMap.searchBox(searchInput,function (dataLatLng) {
                latInput.attr("value", dataLatLng[0]);
                lgnInput.attr("value", dataLatLng[1]);
            });
        }
    });

    });

    $(".bravo-box-category-tour").each(function () {
        $(this).find(".owl-carousel").owlCarousel({
            items: 4,
            loop: true,
            margin: 30,
            nav: false,
            dots: true,
            responsive: {
                0: {
                    items: 1
                },
                768: {
                    items: 2
                },
                1000: {
                    items: 4
                }
            }
        })
    });

    $(".bravo-client-feedback").each(function () {
        $(this).find(".owl-carousel").owlCarousel({
            items: 1,
            loop: true,
            margin: 0,
            nav: true,
            dots: false,
        })
    });

    // Date Picker Range
    $('.form-date-search').each(function () {
        var nowDate = new Date();
        var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
        var parent = $(this),
            date_wrapper = $('.date-wrapper', parent),
            check_in_input = $('.check-in-input', parent),
            check_out_input = $('.check-out-input', parent),
            check_in_out = $('.check-in-out', parent),
            check_in_render = $('.check-in-render', parent),
            check_out_render = $('.check-out-render', parent);
        var options = {
            singleDatePicker: false,
            autoApply: true,
            disabledPast: true,
            customClass: '',
            widthSingle: 300,
            onlyShowCurrentMonth: true,
            minDate: today,
            opens: superio.rtl ? 'right':'left',
            locale: {
                format: "YYYY-MM-DD",
                direction: superio.rtl ? 'rtl':'ltr',
                firstDay:daterangepickerLocale.first_day_of_week
            }
        };
        if (typeof  daterangepickerLocale == 'object') {
            options.locale = _.merge(daterangepickerLocale,options.locale);
        }
        check_in_out.daterangepicker(options,
            function (start, end, label) {
                check_in_input.val(start.format(superio.date_format));
                check_in_render.html(start.format(superio.date_format));
                check_out_input.val(end.format(superio.date_format));
                check_out_render.html(end.format(superio.date_format));
            });
        date_wrapper.on('click',function (e) {
            check_in_out.trigger('click');
        });
    });

    // Date Picker
    $('.date-picker').each(function () {
        var options = {
            "singleDatePicker": true,
            opens: superio.rtl ? 'right':'left',
            locale: {
                format: superio.date_format,
                direction: superio.rtl ? 'rtl':'ltr',
                firstDay:daterangepickerLocale.first_day_of_week
            }
        };
        if (typeof  daterangepickerLocale == 'object') {
            options.locale = _.merge(daterangepickerLocale,options.locale);
        }
        $(this).daterangepicker(options);
    });

    //Login
    $('.bravo-form-login [type=submit]').on('click',function (e) {
        e.preventDefault();
        let form = $(this).closest('.bravo-form-login');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': form.find('input[name="_token"]').val()
            }
        });
        $.ajax({
            'url': superio.routes.login,
            'data': {
                'email': form.find('input[name=email]').val(),
                'password': form.find('input[name=password]').val(),
                'remember': form.find('input[name=remember]').is(":checked") ? 1 : '',
                'g-recaptcha-response': form.find('[name=g-recaptcha-response]').val(),
                'redirect':form.find('input[name=redirect]').val()
            },
            'type': 'POST',
            beforeSend: function () {
                form.find('.error').hide();
                form.find('.icon-loading').css("display", 'inline-block');
            },
            success: function (data) {
                form.find('.icon-loading').hide();
                if (data.error === true) {
                    if (data.messages !== undefined) {
                        for(var item in data.messages) {
                            var msg = data.messages[item];
                            form.find('.error-'+item).show().text(msg[0]);
                        }
                    }
                    if (data.messages.message_error !== undefined) {
                        form.find('.message-error').show().html('<div class="alert alert-danger">' + data.messages.message_error[0] + '</div>');
                    }

                }
                if (typeof data.redirect !== 'undefined' && data.redirect) {
                    window.location.href = data.redirect
                }
            }
        });
    })
    $('.bravo-form-register [type=submit]').on('click',function (e) {
        e.preventDefault();
        let form = $(this).closest('.bravo-form-register');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': form.find('input[name="_token"]').val()
            }
        });
        $.ajax({
            'url':  superio.routes.register,
            'data': {
                'email': form.find('input[name=email]').val(),
                'password': form.find('input[name=password]').val(),
                'type': form.find('input[name=type]:checked').val(),
                //'first_name': form.find('input[name=first_name]').val(),
               // 'last_name': form.find('input[name=last_name]').val(),
                //'phone': form.find('input[name=phone]').val(),
                //'term': form.find('input[name=term]').is(":checked") ? 1 : '',
                'g-recaptcha-response': form.find('[name=g-recaptcha-response]').val(),
            },
            'type': 'POST',
            beforeSend: function () {
                form.find('.error').hide();
                form.find('.icon-loading').css("display", 'inline-block');
            },
            success: function (data) {
                form.find('.icon-loading').hide();
                if (data.error === true) {
                    if (data.messages !== undefined) {
                        for(var item in data.messages) {
                            var msg = data.messages[item];
                            form.find('.error-'+item).show().text(msg[0]);
                        }
                    }
                    if (data.messages.message_error !== undefined) {
                        form.find('.message-error').show().html('<div class="alert alert-danger">' + data.messages.message_error[0] + '</div>');
                    }
                }
                if (data.redirect !== undefined) {
                    window.location.href = data.redirect
                }
            },
            error:function (e) {
                form.find('.icon-loading').hide();
                if(typeof e.responseJSON !== "undefined" && typeof e.responseJSON.message !='undefined'){
                    form.find('.message-error').show().html('<div class="alert alert-danger">' + e.responseJSON.message + '</div>');
                }
            }
        });
    })
    $('#register').on('show.bs.modal', function (event) {
        $('#login').modal('hide')
    })
    $('#login').on('show.bs.modal', function (event) {
        $('#register').modal('hide')
    });

    var onSubmitSubscribe = false;
    //Subscribe box
    $('.bravo-subscribe-form').on('submit',function (e) {
        e.preventDefault();

        if (onSubmitSubscribe) return;

        $(this).addClass('loading');
        var me = $(this);
        me.find('.form-mess').html('');

        $.ajax({
            url: me.attr('action'),
            type: 'post',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (json) {
                onSubmitSubscribe = false;
                me.removeClass('loading');

                if (json.message) {
                    me.find('.form-mess').html('<span class="' + (json.status ? 'text-success' : 'text-danger') + '">' + json.message + '</span>');
                }

                if (json.status) {
                    me.find('input').val('');
                }

            },
            error: function (e) {
                console.log(e);
                onSubmitSubscribe = false;
                me.removeClass('loading');

                if(parseErrorMessage(e)){
                    me.find('.form-mess').html('<span class="text-danger">' + parseErrorMessage(e) + '</span>');
                }else
                if (e.responseText) {
                    me.find('.form-mess').html('<span class="text-danger">' + e.responseText + '</span>');
                }

            }
        });

        return false;
    });

    //Menu
    $(".bravo-more-menu").on('click',function () {
        $(this).trigger('bravo-trigger-menu-mobile');
    });
    $(".bravo-menu-mobile .b-close").on('click',function () {
        $(".bravo-more-menu").trigger('bravo-trigger-menu-mobile');
    });
    $(document).on("click",".bravo-effect-bg",function () {
        $(".bravo-more-menu").trigger('bravo-trigger-menu-mobile');
    })
    $(document).on("bravo-trigger-menu-mobile",".bravo-more-menu",function () {
        $(this).toggleClass('active');
        if($(this).hasClass('active')){
            $(".bravo-menu-mobile").addClass("active");
            $('body').css('overflow','hidden').append("<div class='bravo-effect-bg'></div>");
        }else{
            $(".bravo-menu-mobile").removeClass("active");
            $("body").css('overflow','initial').find(".bravo-effect-bg").remove();
        }
    });
    $(".bravo-menu-mobile .g-menu ul li .fa").on('click',function (e) {
        e.preventDefault();
        $(this).closest('li').toggleClass('active');
    });
    $(".bravo-menu-mobile").each(function () {
        var h_profile = $(this).find(".user-profile").height();
        var h1_main = $(window).height();
        $(this).find(".g-menu").css("max-height", h1_main - h_profile - 15);
    });

    $(".bravo-more-menu-user").on('click',function () {
        $(".bravo_user_profile > .container-fluid > .row > .col-md-3").addClass("active");
        $("body").css('overflow','hidden').append("<div class='bravo-effect-user-bg'></div>");
    });
    $(document).on("click",".bravo-effect-user-bg,.bravo-close-menu-user",function () {
        $(".bravo_user_profile > .container-fluid > .row > .col-md-3").removeClass("active");
        $('body').css('overflow','initial').find(".bravo-effect-user-bg").remove();
    })

    $('.bravo-video-popup').on('click',function() {
        let video_url = $(this).data( "src" );
        let target = $(this).data( "target" );
        $(target).find(".bravo_embed_video").attr('src',video_url + "?autoplay=0&amp;modestbranding=1&amp;showinfo=0" );
        $(target).on('hidden.bs.modal', function () {
            $(target).find(".bravo_embed_video").attr('src',"" );
        });
    });

    var onSubmitContact = false;
    //Contact box
    $('.bravo-contact-block-form').on('submit',function (e) {
        e.preventDefault();
        if (onSubmitContact) return;
        $(this).addClass('loading');
        var me = $(this);
        me.find('.form-mess').html('');
        $.ajax({
            url: me.attr('action'),
            type: 'post',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (json) {
                onSubmitContact = false;
                me.removeClass('loading');
                if (json.message) {
                    me.find('.form-mess').html('<span class="' + (json.status ? 'text-success' : 'text-danger') + '">' + json.message + '</span>');
                }
                if (json.status) {
                    me.find('input').val('');
                    me.find('textarea').val('');
                }
            },
            error: function (e) {
                console.log(e);
                onSubmitContact = false;
                me.removeClass('loading');
                if(parseErrorMessage(e)){
                    me.find('.form-mess').html('<span class="text-danger">' + parseErrorMessage(e) + '</span>');
                }else
                if (e.responseText) {
                    me.find('.form-mess').html('<span class="text-danger">' + e.responseText + '</span>');
                }
            }
        });
        return false;
    });

    $('.btn-submit-enquiry').on('click',function (e) {

        e.preventDefault();
        let form = $(this).closest('.enquiry_form_modal_form');

        $.ajax({
            url:superio.url+'/booking/addEnquiry',
            data:form.find('textarea,input,select').serialize(),
            dataType:'json',
            type:'post',
            beforeSend: function () {
                form.find('.message_box').html('').hide();
                form.find('.icon-loading').css("display", 'inline-block');
            },
            success:function(res){
                if(res.errors){
                    res.message = '';
                    for(var k in res.errors){
                        res.message += res.errors[k].join('<br>')+'<br>';
                    }
                }
                if(res.message)
                {
                    if(!res.status){
                        form.find('.message_box').append('<div class="text text-danger">'+res.message+'</div>').show();
                    }else{
                        form.find('.message_box').append('<div class="text text-success">'+res.message+'</div>').show();
                    }
                }

                form.find('.icon-loading').hide();

                if(res.status){
                    form.find('textarea,input,select').val('');
                }

                if(typeof BravoReCaptcha != "undefined"){
                    BravoReCaptcha.reset('enquiry_form');
                }
            },
            error:function (e) {
                if(typeof BravoReCaptcha != "undefined"){
                    BravoReCaptcha.reset('enquiry_form');
                }
                form.find('.icon-loading').hide();
            }
        })
    })

    $('.review_upload_file').on('change',function () {
        var me = $(this);
        var p = $(this).closest('.review_upload_wrap');
        var lists = p.find('.review_upload_photo_list');

        me.isLoading = true;
        for(var i = 0 ;i < me.get(0).files.length ; i++) {
            var d = new FormData();
            d.append('type','image');
            d.append('file',me.get(0).files[i]);
            if(!me.showErr){
                $.ajax({
                    url: superio.url + '/media/private/store',
                    data: d,
                    dataType: 'json',
                    type: 'post',
                    contentType: false,
                    processData: false,
                    success: function (res) {
                        me.val('');
                        if (res.status === 0) {
                            superioApp.showError(res);
                        }
                        if (res.data) {
                            var count = $(".review_upload_photo_list > .col-md-2").length;
                            if(count > 5){
                                superioApp.showError('Maximum upload 6 pictures');
                            }else{
                                var div = $('<div class="col-md-2 mb-2"/>');
                                var item = $('<div class="review_upload_item"/>');
                                div.append(item);
                                var input = $("<input/>");
                                input.attr('type', 'hidden');
                                input.attr('name', me.data('name')+'[]');
                                input.val(JSON.stringify(res.data));

                                item.append(input);
                                item.css({
                                    'background-image':'url('+res.data.download+')'
                                });

                                if (me.data('multiple')) {
                                    lists.append(div);
                                } else {
                                    lists.html(div);
                                }
                            }

                        }
                    },
                    error: function (e) {
                        superioApp.showAjaxError(e);
                        me.val('');
                    }
                })
            }

        }

        $(this).val('');
    })

    $('.review_upload_item').on('click',function (e) {
        var p  = $(e.target).data('target');
        var fotorama = $(p+' .fotorama').fotorama();

    });




    //Superio

    // Fancybox
    if($(".travel-fancybox").length){
        var conf = {
            parentEl: 'html',
            baseClass: 'u-fancybox-theme',
            slideClass: 'u-fancybox-slide',
            speed: 1000,
            slideSpeedCoefficient: 1,
            infobar: false,
            fullScreen: true,
            thumbs: true,
            closeBtn: true,
            baseTpl: '<div class="fancybox-container" role="dialog" tabindex="-1">' +
                '<div class="fancybox-content">' +
                '<div class="fancybox-bg"></div>' +
                '<div class="fancybox-controls" style="position: relative; z-index: 99999;">' +
                '<div class="fancybox-infobar">' +
                '<div class="fancybox-infobar__body">' +
                '<span data-fancybox-index></span>&nbsp;/&nbsp;<span data-fancybox-count></span>' +
                '</div>' +
                '</div>' +
                '<div class="fancybox-toolbar">{{BUTTONS}}</div>' +
                '</div>' +
                '<div class="fancybox-slider-wrap">' +
                '<button data-fancybox-prev class="fancybox-arrow fancybox-arrow--left" title="Previous"></button>' +
                '<button data-fancybox-next class="fancybox-arrow fancybox-arrow--right" title="Next"></button>' +
                '<div class="fancybox-stage"></div>' +
                '</div>' +
                '<div class="fancybox-caption-wrap">' +
                '<div class="fancybox-caption"></div>' +
                '</div>' +
                '</div>' +
                '</div>',
            animationEffect: 'fade'
        };
        var $fancybox = $(".travel-fancybox");
        $fancybox.on('click', function () {
            var $this = $(this),
                animationDuration = $this.data('speed'),
                isGroup = $this.data('fancybox'),
                isInfinite = Boolean($this.data('is-infinite')),
                isSlideShowAutoStart = Boolean($this.data('is-slideshow-auto-start')),
                slideShowSpeed = $this.data('slideshow-speed');

            $.fancybox.defaults.animationDuration = animationDuration;

            if (isInfinite === true) {
                $.fancybox.defaults.loop = true;
            }

            if (isSlideShowAutoStart === true) {
                $.fancybox.defaults.slideShow.autoStart = true;
            } else {
                $.fancybox.defaults.slideShow.autoStart = false;
            }

            if (isGroup) {
                $.fancybox.defaults.transitionEffect = 'slide';
                $.fancybox.defaults.slideShow.speed = slideShowSpeed;
            }
        });


        $fancybox.fancybox($.extend(true, {}, conf, {
            beforeShow: function (instance, slide) {
                var $fancyModal = $(instance.$refs.container),
                    $fancyOverlay = $(instance.$refs.bg[0]),
                    $fancySlide = $(instance.current.$slide),

                    animateIn = instance.current.opts.$orig[0].dataset.animateIn,
                    animateOut = instance.current.opts.$orig[0].dataset.animateOut,
                    speed = instance.current.opts.$orig[0].dataset.speed,
                    overlayBG = instance.current.opts.$orig[0].dataset.overlayBg,
                    overlayBlurBG = instance.current.opts.$orig[0].dataset.overlayBlurBg;

                if (animateIn && $('body').hasClass('u-first-slide-init')) {
                    var $fancyPrevSlide = $(instance.slides[instance.prevPos].$slide);

                    $fancySlide.addClass('has-animation');

                    $fancyPrevSlide.addClass('animated ' + animateOut);

                    setTimeout(function () {
                        $fancySlide.addClass('animated ' + animateIn);
                    }, speed / 2);
                } else if (animateIn) {
                    var $fancyPrevSlide = $(instance.slides[instance.prevPos].$slide);

                    $fancySlide.addClass('has-animation');

                    $fancySlide.addClass('animated ' + animateIn);

                    $('body').addClass('u-first-slide-init');

                    $fancySlide.on('animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd', function (e) {
                        $fancySlide.removeClass(animateIn);
                    });
                }

                if (speed) {
                    $fancyOverlay.css('transition-duration', speed + 'ms');
                } else {
                    $fancyOverlay.css('transition-duration', '1000ms');
                }

                if (overlayBG) {
                    $fancyOverlay.css('background-color', overlayBG);
                }

                if (overlayBlurBG) {
                    $('body').addClass('u-blur-30');
                }
            },

            beforeClose: function (instance, slide) {
                var $fancyModal = $(instance.$refs.container),
                    $fancySlide = $(instance.current.$slide),

                    animateIn = instance.current.opts.$orig[0].dataset.animateIn,
                    animateOut = instance.current.opts.$orig[0].dataset.animateOut,
                    overlayBlurBG = instance.current.opts.$orig[0].dataset.overlayBlurBg;

                if (animateOut) {
                    $fancySlide.removeClass(animateIn).addClass(animateOut);
                    $('body').removeClass('u-first-slide-init')
                }

                if (overlayBlurBG) {
                    $('body').removeClass('u-blur-30')
                }
            }
        }));
    }

    //Review
    $('.sfeedbacks_form .sspd_review .fa').each(function () {
        var list = $(this).parent(),
            listItems = list.children(),
            itemIndex = $(this).index(),
            parentItem = list.parent();
            $(this).hover(function(){
                for (var i = 0; i < listItems.length; i++) {
                    if (i <= itemIndex) {
                        $(listItems[i]).addClass('hovered');
                    } else {
                        break;
                    }
                }
                $(this).click(function(){
                    for (var i = 0; i < listItems.length; i++) {
                        if (i <= itemIndex) {
                            $(listItems[i]).addClass('selected');
                        } else {
                            $(listItems[i]).removeClass('selected');
                        }
                    }
                    parentItem.children('.review_stats').val(itemIndex + 1);
                });
            }, function () {
                listItems.removeClass('hovered');
            });
    });

    // Caroseo
    $(".travel-slick-carousel").each(function (i, el) {
        //Variables
        var $self = $(el),
            config = $self.config,
            collection = $self.pageCollection;
        //Actions

        var $this = $(el),
            id = $this.attr('id'),

            //Markup elements
            target = $this.data('nav-for'),
            isThumb = $this.data('is-thumbs'),
            arrowsClasses = $this.data('arrows-classes'),
            arrowLeftClasses = $this.data('arrow-left-classes'),
            arrowRightClasses = $this.data('arrow-right-classes'),
            pagiClasses = $this.data('pagi-classes'),
            pagiHelper = $this.data('pagi-helper'),
            $pagiIcons = $this.data('pagi-icons'),
            $prevMarkup = '<div class="js-prev ' + arrowsClasses + ' ' + arrowLeftClasses + '"></div>',
            $nextMarkup = '<div class="js-next ' + arrowsClasses + ' ' + arrowRightClasses + '"></div>',

            //Setters
            setSlidesToShow = $this.data('slides-show'),
            setSlidesToScroll = $this.data('slides-scroll'),
            setAutoplay = $this.data('autoplay'),
            setAnimation = $this.data('animation'),
            setEasing = $this.data('easing'),
            setFade = $this.data('fade'),
            setSpeed = $this.data('speed'),
            setSlidesRows = $this.data('rows'),
            setCenterMode = $this.data('center-mode'),
            setCenterPadding = $this.data('center-padding'),
            setPauseOnHover = $this.data('pause-hover'),
            setVariableWidth = $this.data('variable-width'),
            setInitialSlide = $this.data('initial-slide'),
            setVertical = $this.data('vertical'),
            setRtl = $this.data('rtl'),
            setInEffect = $this.data('in-effect'),
            setOutEffect = $this.data('out-effect'),
            setInfinite = $this.data('infinite'),
            setDataTitlePosition = $this.data('title-pos-inside'),
            setFocusOnSelect = $this.data('focus-on-select'),
            setLazyLoad = $this.data('lazy-load'),
            isAdaptiveHeight = $this.data('adaptive-height'),
            numberedPaging = $this.data('numbered-pagination'),
            setResponsive = JSON.parse(el.getAttribute('data-responsive'));

        if ($this.find('[data-slide-type]').length) {
            $self.videoSupport($this);
        }

        $this.on('init', function (event, slick) {
            $(slick.$slides).css('height', 'auto');

            if (isThumb && setSlidesToShow >= $(slick.$slides).length) {
                $this.addClass('slick-transform-off');
            }
        });

        $this.on('init', function (event, slick) {
            var slide = $(slick.$slides)[slick.currentSlide],
                animatedElements = $(slide).find('[data-scs-animation-in]');

            $(animatedElements).each(function () {
                var animationIn = $(this).data('scs-animation-in'),
                    animationDelay = $(this).data('scs-animation-delay'),
                    animationDuration = $(this).data('scs-animation-duration');

                $(this).css({
                    'animation-delay': animationDelay + 'ms',
                    'animation-duration': animationDuration + 'ms'
                });

                $(this).addClass('animated ' + animationIn).css('opacity', 1);
            });
        });

        if (setInEffect && setOutEffect) {
            $this.on('init', function (event, slick) {
                $(slick.$slides).addClass('single-slide');
            });
        }

        if (pagiHelper) {
            $this.on('init', function (event, slick) {
                var $pagination = $this.find('.js-pagination');

                if (!$pagination.length) return;

                $pagination.append('<span class="u-dots-helper"></span>');
            });
        }

        if (isThumb) {
            $('#' + id).on('click', '.slick-slide', function (e) {
                e.stopPropagation();

                //Variables
                var i = $(this).data('slick-index');

                if ($('#' + id).slick('slickCurrentSlide') !== i) {
                    $('#' + id).slick('slickGoTo', i);
                }
            });
        }

        $this.on('init', function (event, slider) {
            var $pagination = $this.find('.js-pagination');

            if (!$pagination.length) return;

            $($pagination[0].children[0]).addClass('slick-current');
        });

        $this.on('init', function (event, slick) {
            var slide = $(slick.$slides)[0],
                animatedElements = $(slide).find('[data-scs-animation-in]');

            $(animatedElements).each(function () {
                var animationIn = $(this).data('scs-animation-in');

                $(this).addClass('animated ' + animationIn).css('opacity', 1);
            });
        });

        if (numberedPaging) {
            $this.on('init', function (event, slick) {
                $(numberedPaging).html('<span class="u-paging__current">1</span><span class="u-paging__divider"></span><span class="u-paging__total">' + slick.slideCount + '</span>');
            });
        }

        $this.slick({
            autoplay: setAutoplay ? true : false,
            autoplaySpeed: setSpeed ? setSpeed : 3000,

            cssEase: setAnimation ? setAnimation : 'ease',
            easing: setEasing ? setEasing : 'linear',
            fade: setFade ? true : false,

            infinite: setInfinite ? true : false,
            initialSlide: setInitialSlide ? setInitialSlide - 1 : 0,
            slidesToShow: setSlidesToShow ? setSlidesToShow : 1,
            slidesToScroll: setSlidesToScroll ? setSlidesToScroll : 1,
            centerMode: setCenterMode ? true : false,
            variableWidth: setVariableWidth ? true : false,
            pauseOnHover: setPauseOnHover ? true : false,
            rows: setSlidesRows ? setSlidesRows : 1,
            vertical: setVertical ? true : false,
            verticalSwiping: setVertical ? true : false,
            rtl: setRtl ? true : false,
            centerPadding: setCenterPadding ? setCenterPadding : 0,
            focusOnSelect: setFocusOnSelect ? true : false,
            lazyLoad: setLazyLoad ? setLazyLoad : false,

            asNavFor: target ? target : false,
            prevArrow: arrowsClasses ? $prevMarkup : false,
            nextArrow: arrowsClasses ? $nextMarkup : false,
            dots: pagiClasses ? true : false,
            dotsClass: 'js-pagination ' + pagiClasses,
            adaptiveHeight: !!isAdaptiveHeight,
            customPaging: function (slider, i) {
                var title = $(slider.$slides[i]).data('title');

                if (title && $pagiIcons) {
                    return '<span>' + title + '</span>' + $pagiIcons;
                } else if ($pagiIcons) {
                    return '<span></span>' + $pagiIcons;
                } else if (title && setDataTitlePosition) {
                    return '<span>' + title + '</span>';
                } else if (title && !setDataTitlePosition) {
                    return '<span></span>' + '<strong class="u-dot-title">' + title + '</strong>';
                } else {
                    return '<span></span>';
                }
            },
            responsive: setResponsive
        });

        $this.on('beforeChange', function (event, slider, currentSlide, nextSlide) {
            var nxtSlide = $(slider.$slides)[nextSlide],
                slide = $(slider.$slides)[currentSlide],
                $pagination = $this.find('.js-pagination'),
                animatedElements = $(nxtSlide).find('[data-scs-animation-in]'),
                otherElements = $(slide).find('[data-scs-animation-in]');

            $(otherElements).each(function () {
                var animationIn = $(this).data('scs-animation-in');

                $(this).removeClass('animated ' + animationIn);
            });

            $(animatedElements).each(function () {
                $(this).css('opacity', 0);
            });

            if (!$pagination.length) return;

            if (currentSlide > nextSlide) {
                $($pagination[0].children).removeClass('slick-active-right');

                $($pagination[0].children[nextSlide]).addClass('slick-active-right');
            } else {
                $($pagination[0].children).removeClass('slick-active-right');
            }

            $($pagination[0].children).removeClass('slick-current');

            setTimeout(function () {
                $($pagination[0].children[nextSlide]).addClass('slick-current');
            }, .25);
        });

        if (numberedPaging) {
            $this.on('beforeChange', function (event, slick, currentSlide, nextSlide) {
                var i = (nextSlide ? nextSlide : 0) + 1;

                $(numberedPaging).html('<span class="u-paging__current">' + i + '</span><span class="u-paging__divider"></span><span class="u-paging__total">' + slick.slideCount + '</span>');
            });
        }

        $this.on('afterChange', function (event, slick, currentSlide) {
            var slide = $(slick.$slides)[currentSlide],
                animatedElements = $(slide).find('[data-scs-animation-in]');

            $(animatedElements).each(function () {
                var animationIn = $(this).data('scs-animation-in'),
                    animationDelay = $(this).data('scs-animation-delay'),
                    animationDuration = $(this).data('scs-animation-duration');

                $(this).css({
                    'animation-delay': animationDelay + 'ms',
                    'animation-duration': animationDuration + 'ms'
                });

                $(this).addClass('animated ' + animationIn).css('opacity', 1);
            });
        });

        if (setInEffect && setOutEffect) {
            $this.on('afterChange', function (event, slick, currentSlide, nextSlide) {
                $(slick.$slides).removeClass('animated set-position ' + setInEffect + ' ' + setOutEffect);
            });

            $this.on('beforeChange', function (event, slick, currentSlide) {
                $(slick.$slides[currentSlide]).addClass('animated ' + setOutEffect);
            });

            $this.on('setPosition', function (event, slick) {
                $(slick.$slides[slick.currentSlide]).addClass('animated set-position ' + setInEffect);
            });
        }

    });

    $('[data-toggle="tooltip"]').tooltip();

    $('.dropdown-toggle').dropdown();

    $('.select-guests-dropdown .btn-minus').on('click',function(e){
        e.stopPropagation();
        var parent = $(this).closest('.form-select-guests');
        var input = parent.find('.select-guests-dropdown [name='+$(this).data('input')+']');
        var min = parseInt(input.attr('min'));
        var old = parseInt(input.val());

        if(old <= min){
            return;
        }
        input.val(old-1);
        updateGuestCountText(parent);
    });

    $('.select-guests-dropdown .btn-add').on('click',function(e){
        e.stopPropagation();
        var parent = $(this).closest('.form-select-guests');
        var input = parent.find('.select-guests-dropdown [name='+$(this).data('input')+']');
        var max = parseInt(input.attr('max'));
        var old = parseInt(input.val());

        if(old >= max){
            return;
        }
        input.val(old+1);
        updateGuestCountText(parent);
    });

    $('.select-guests-dropdown input').on('keyup',function(e){
        var parent = $(this).closest('.form-select-guests');
        updateGuestCountText(parent);
    });
    $('.select-guests-dropdown input').on('change',function(e){
        var parent = $(this).closest('.form-select-guests');
        updateGuestCountText(parent);
    });

    function updateGuestCountText(parent){
        var adults = parseInt(parent.find('[name=adults]').val());
        var children = parseInt(parent.find('[name=children]').val());

        var adultsHtml = parent.find('.render .adults .multi').data('html');
        console.log(parent,adultsHtml);
        parent.find('.render .adults .multi').html(adultsHtml.replace(':count',adults));

        var childrenHtml = parent.find('.render .children .multi').data('html');
        parent.find('.render .children .multi').html(childrenHtml.replace(':count',children));
        if(adults > 1){
            parent.find('.render .adults .multi').removeClass('d-none');
            parent.find('.render .adults .one').addClass('d-none');
        }else{
            parent.find('.render .adults .multi').addClass('d-none');
            parent.find('.render .adults .one').removeClass('d-none');
        }

        if(children > 1){
            parent.find('.render .children .multi').removeClass('d-none');
            parent.find('.render .children .one').addClass('d-none');
        }else{
            parent.find('.render .children .multi').addClass('d-none');
            parent.find('.render .children .one').removeClass('d-none').html(parent.find('.render .children .one').data('html').replace(':count',children));
        }

    }

    $('.select-guests-dropdown .dropdown-item-row').on('click',function(e){
        e.stopPropagation();
    });



    //Flight

    $('.custom-select-dropdown .btn-minus').on('click',function(e){
        e.stopPropagation();
        var parent = $(this).closest('.custom-select-dropdown-parent');
        var inputAttr = $(this).data('input-attr');
        if(typeof inputAttr =='undefined'){
            inputAttr = 'name';
        }
        var input = parent.find('.custom-select-dropdown ['+inputAttr+'='+$(this).data('input')+']');
        var min = parseInt(input.attr('min'));
        var old = parseInt(input.val());

        if(old <= min){
            return;
        }
        input.val(old-1);
        updateCustomSelectDropdown(input);
    });

    $('.custom-select-dropdown .btn-add').on('click',function(e){
        e.stopPropagation();
        var parent = $(this).closest('.custom-select-dropdown-parent');
        var inputAttr = $(this).data('input-attr');
        if(typeof inputAttr =='undefined'){
            inputAttr = 'name';
        }
        var input = parent.find('.custom-select-dropdown ['+inputAttr+'='+$(this).data('input')+']');
        var max = parseInt(input.attr('max'));
        var old = parseInt(input.val());

        if(old >= max){
            return;
        }
        input.val(old+1);
       updateCustomSelectDropdown(input);
    });
    $('.custom-select-dropdown input').on('keyup',function(e){
        updateCustomSelectDropdown($(this));
    });
    $('.custom-select-dropdown input').on('change',function(e){
        updateCustomSelectDropdown($(this));
    });

    function updateCustomSelectDropdown(input){
        var parent =input.closest('.custom-select-dropdown-parent');
        var target = input.attr('id');
        var number = parseInt(input.val());
        var render = parent.find('[id='+target+'_render]')

        var htmlString = render.find('.multi').data('html');
        var min = input.attr('min')
        console.log(
            render
        )
        if(number > min){
            render.find('.multi').removeClass('d-none').html(htmlString.replace(':count',number));
            render.find('.one').addClass('d-none');
        }else{
            render.find('.multi').addClass('d-none');
            render.find('.one').removeClass('d-none');
        }
    }
    $('.custom-select-dropdown .dropdown-item-row').on('click',function(e){
        e.stopPropagation();
    });





    $(".smart-search .smart-search-location").each(function () {
        var $this = $(this);
        var string_list = $this.attr('data-default');
        var default_list = [];
        if(string_list.length > 0){
            default_list = JSON.parse(string_list);
        }
        var options = {
            url: superio.url+'/location/search/searchForSelect2',
            dataDefault: default_list,
            textLoading: $this.attr("data-onLoad"),
            iconItem: "icofont-location-pin",
        };
        $this.bravoAutocomplete(options);
    });

    $(".smart-search .smart-select").each(function () {
        var $this = $(this);
        var string_list = $this.attr('data-default');
        var default_list = [];
        if(string_list.length > 0){
            default_list = JSON.parse(string_list);
        }
        var options = {
            dataDefault: default_list,
            iconItem: "",
            textLoading: $this.attr("data-onLoad"),
        };
        $this.bravoAutocomplete(options);
    });

    $(document).on("click",".service-wishlist",function(){
        var $this = $(this);
        $.ajax({
            url:  superio.url+'/user/wishlist',
            data: {
                object_id: $this.attr("data-id"),
                object_model: $this.attr("data-type"),
            },
            dataType: 'json',
            type: 'POST',
            beforeSend: function() {
                $this.addClass("loading");
            },
            success: function (res) {
                $($this).removeClass("active");
                $this.removeClass("loading");
                $this.addClass(res.class);
                if(res.fragments){
                    for(var k in res.fragments){
                        $(k).html(res.fragments[k]);
                    }
                }
            },
            error:function (e) {
                $this.removeClass("loading");
                if(e.status === 401){
                    $('#login').modal('show');
                }
            }
        })
    });

    //Video Play

    if($(".travel-inline-video-player").length){
        $(".travel-inline-video-player").each(function (i, el) {
            var $this = $(el),
                parent = $this.data('parent'),
                target = $this.data('target'),
                SRC = $this.data('video-id'),
                videoType = $this.data('video-type'),
                classes = $this.data('classes'),
                isAutoPlay = Boolean($this.data('is-autoplay'));

            if (videoType !== 'vimeo') {
                youTubeAPIReady();
            }
            $this.on('click', function (e) {
                e.preventDefault();
                $('#' + parent).toggleClass(classes);
                if (videoType === 'vimeo') {
                    vimeoPlayer(target, SRC, isAutoPlay);

                } else {
                   youTubePlayer(target, SRC, isAutoPlay);
                }
            });
        });
        function youTubeAPIReady() {
            var YTScriptTag = document.createElement('script');
            YTScriptTag.src = '//www.youtube.com/player_api';

            var DOMfirstScriptTag = document.getElementsByTagName('script')[0];
            DOMfirstScriptTag
                .parentNode
                .insertBefore(YTScriptTag, DOMfirstScriptTag);
        }
        function youTubePlayer(target, src, autoplay) {
            var YTPlayer = new YT.Player(target, {
                videoId: src,
                playerVars: {
                    origin: window.location.origin,
                    autoplay: autoplay === true ? 1 : 0
                }
            });
        }
        function vimeoPlayer(target, src, autoplay) {
            var vimeoIframe = document.getElementById(target),
            vimeoPlayer = new Vimeo.Player(vimeoIframe, {
                id: src,
                autoplay: autoplay === true ? 1 : 0
            });
        }
    };

//    modal

    $('.travel-go-to').each(function (i, el) {
        var $this = $(el),
            $target = $this.data('target'),
            isReferencedToPage = Boolean($this.data('is-referenced-to-page')),
            type = $this.data('type'),
            showEffect = $this.data('show-effect'),
            hideEffect = $this.data('hide-effect'),
            position = JSON.parse(el.getAttribute('data-position')),
            compensation = $($this.data('compensation')).outerHeight(),
            offsetTop = $this.data('offset-top'),
            targetOffsetTop = function () {
                if (compensation) {
                    return $target ? $($target).offset().top - compensation : 0;
                } else {
                    return $target ? $($target).offset().top : 0;
                }
            };
        if (type === 'static') {
            $this.css({
                'display': 'inline-block'
            });
        } else {
            $this.addClass('animated').css({
                'display': 'inline-block',
                'position': type,
                'opacity': 0
            });
        }
        if (type === 'fixed' || type === 'absolute') {
            $this.css(position);
        }
        $this.on('click', function (e) {
            if (!isReferencedToPage) {
                e.preventDefault();

                $('html, body').stop().animate({
                    'scrollTop': targetOffsetTop()
                }, 800);
            }
        });
        if (!$this.data('offset-top') && !$this.hasClass('js-animation-was-fired') && type !== 'static') {
            if ($this.offset().top <= $(window).height()) {
                $this.show();

                setTimeout(function () {
                    $this.addClass('js-animation-was-fired ' + showEffect).css({
                        'opacity': ''
                    });
                });
            }
        }
        if (type !== 'static') {
            $(window).on('scroll', function () {
                clearTimeout($.data(this, 'scrollTimer'));
                if ($this.data('offset-top')) {
                    if ($(window).scrollTop() >= offsetTop && !$this.hasClass('js-animation-was-fired')) {
                        $this.show();

                        setTimeout(function () {
                            $this.addClass('js-animation-was-fired ' + showEffect).css({
                                'opacity': ''
                            });
                        });
                    } else if ($(window).scrollTop() <= offsetTop && $this.hasClass('js-animation-was-fired')) {
                        $.data(this, 'scrollTimer', setTimeout(function () {

                            $this.removeClass('js-animation-was-fired ' + showEffect);

                            setTimeout(function () {
                                $this.addClass(hideEffect).css({
                                    'opacity': 0
                                });
                            }, 100);

                            setTimeout(function () {
                                $this.removeClass(hideEffect).hide();
                            }, 400);

                        }, 500));
                    }
                } else {
                    var thisOffsetTop = $this.offset().top;

                    if (!$this.hasClass('js-animation-was-fired')) {
                        if ($(window).scrollTop() >= thisOffsetTop - $(window).height()) {
                            $this.show();

                            setTimeout(function () {
                                $this.addClass('js-animation-was-fired ' + showEffect).css({
                                    'opacity': ''
                                });
                            });
                        }
                    }
                }
            });
            $(window).trigger('scroll');
        }

    });

    $(document).on('click', '.bc-call-modal.login', function(event) {
        event.preventDefault();
        this.blur();
        $("#login").modal({
            fadeDuration: 300,
            fadeDelay: 0.15
        });
    })

    $(document).on('click', '.bc-call-modal.signup', function(event) {
        event.preventDefault();
        this.blur();
        $("#register").modal({
            fadeDuration: 300,
            fadeDelay: 0.15
        });
    });
    let closeAlert;
    $(".bc-require-candidate-apply").on("click", function (e) {
        e.preventDefault();
        $(".bc-alert-popup").addClass("active").find('.message-box').html($(this).attr('data-require-text'));
        if(closeAlert){
            clearTimeout(closeAlert);
        }
        closeAlert = setTimeout(function(){
            $(".bc-alert-popup").removeClass('active').find('.message-box').empty();
            }, 3000);
    })

    $(document).on('click', '.bc-call-modal.apply-job', function(event) {
        event.preventDefault();
        this.blur();
        $("#apply-job").modal({
            fadeDuration: 300,
            fadeDelay: 0.15
        });
    });

    let cv_file, file;
    if($(".bc-drag-area").length > 0) {
        //selecting all required elements
        const dropArea = document.querySelector(".bc-drag-area"),
            button = $(".bc-drag-area button"),
            input = $(".bc-drag-area input");

        button.on("click", function () {
            input.click();
        });
        input.on("change", function () {
            if (this.files[0]) {
                file = this.files[0];
                dropArea.classList.add("active");
                showFile();
            }
        })

        dropArea.addEventListener("dragover", (event) => {
            event.preventDefault();
            dropArea.classList.add("active");
        });

        dropArea.addEventListener("dragleave", () => {
            dropArea.classList.remove("active");
        });
        dropArea.addEventListener("drop", (event) => {
            event.preventDefault();
            file = event.dataTransfer.files[0];
            showFile();
        });
        $(".bc-drag-area").on("click", ".remove-file", function () {
            file = false;
            cv_file = false;
            input.val(null);
            button.text(button.attr('data-text'));
            dropArea.classList.remove("active");
            dropArea.classList.remove("has-file");
        });

        function showFile() {
            let fileType = file.type;
            let validExtensions = ["application/pdf", "application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document"];
            if (validExtensions.includes(fileType)) {
                button.text(file.name);
                cv_file = file;
                dropArea.classList.add("has-file");
                // let fileReader = new FileReader();
                // fileReader.onload = ()=>{
                //     let fileURL = fileReader.result;
                // }
                // fileReader.readAsDataURL(file);
            } else {
                alert("This file is not supported");
                dropArea.classList.remove("active");
            }
        }
    }

    var applyJobAjax;
    $(".job-apply-form").on("submit", function (e) {
        e.preventDefault();

        var t = $(this);
        if (applyJobAjax) {
            applyJobAjax.abort();
        }
        if (t.hasClass('loading')) {
            return false;
        }
        var form_id = $(this).attr('id');
        var error = true;
        if (t.find('input[name="apply_cv_id"]:checked').val() || cv_file) {
            error = false;
        }

        if (!error) {
            t.find('.alert').remove();
            t.addClass('loading');
            t.find('apply-alert').remove();
            var form_data = new FormData($('#' + form_id)[0]);

            if(cv_file){
                form_data.append('cv_file', cv_file);
            }
            applyJobAjax = $.ajax({
                url: superio.routes.applyJob,
                type: 'POST',
                dataType: 'json',
                data: form_data,
                processData: false,
                contentType: false,
                success:function(res){
                    t.removeClass('loading');
                    if(res.status == 1){
                        t.prepend('<div class="apply-alert message-box success">' + res.message + '</div>');
                        $('.bc-apply-job-button').removeClass('.bc-call-modal').text(i18n.applied);
                        cv_file = false;
                        setTimeout(function () {
                            $("#apply-job").modal('hide').parent().removeClass("blocker").remove();
                            $("body").css({overflow : 'auto'});
                        }, 2000);
                    }else{
                        t.prepend('<div class="apply-alert message-box error">' + res.message + '</div>');
                    }
                },
                error:function (e) {
                    console.log(e);
                    t.removeClass('loading');
                }
            });
        } else {
            alert(i18n.chooseACv);
        }
    })


    $('.review_upload_file').change(function () {
        var me = $(this);
        var p = $(this).closest('.review_upload_wrap');
        var lists = p.find('.review_upload_photo_list');

        me.isLoading = true;
        for(var i = 0 ;i < me.get(0).files.length ; i++) {
            var d = new FormData();
            d.append('type','image');
            d.append('file',me.get(0).files[i]);
            if(!me.showErr){
                $.ajax({
                    url: bookingCore.url + '/media/private/store',
                    data: d,
                    dataType: 'json',
                    type: 'post',
                    contentType: false,
                    processData: false,
                    success: function (res) {
                        me.val('');
                        if (res.status === 0) {
                            bookingCoreApp.showError(res);
                        }
                        if (res.data) {
                            var count = $(".review_upload_photo_list > .col-md-2").length;
                            if(count > 5){
                                bookingCoreApp.showError('Maximum upload 6 pictures');
                            }else{
                                var div = $('<div class="col-md-2 mb-2"/>');
                                var item = $('<div class="review_upload_item"/>');
                                div.append(item);
                                var input = $("<input/>");
                                input.attr('type', 'hidden');
                                input.attr('name', me.data('name')+'[]');
                                input.val(JSON.stringify(res.data));

                                item.append(input);
                                item.css({
                                    'background-image':'url('+res.data.download+')'
                                });

                                if (me.data('multiple')) {
                                    lists.append(div);
                                } else {
                                    lists.html(div);
                                }
                            }

                        }
                    },
                    error: function (e) {
                        bookingCoreApp.showAjaxError(e);
                        me.val('');
                    }
                })
            }

        }

        $(this).val('');
    });

    $(".bc-select-has-delete .chosen-select").on("change", function (evt, params) {
        deleteSelect($(this));
    });

    function deleteSelect(t) {
        var selected = t.val();
        if(selected){
            t.closest('.bc-select-has-delete').find('.remove-selected').remove();
            t.closest('.bc-select-has-delete').append('<span class="remove-selected"><i class="flaticon-close-1"></i></span>');
        }
    }
    $(".bc-select-has-delete .chosen-select").each(function(){
        deleteSelect($(this));
    });

    $(".bc-select-has-delete").on("click", ".remove-selected", function () {
        var select = $(this).closest(".bc-select-has-delete").find(".chosen-select");
        select.val('');
        select.trigger("chosen:updated");
        var selected = select.find(":selected").text();
        $(this).closest(".bc-select-has-delete").find(".chosen-single span").text(selected);

        $(this).remove();
    });

    $(window).load(function () {
        var ww = $(window).width();
        var hh = $("header.main-header").height();
        if(ww > 1024) {
            $(".header-span").css({height: hh + 'px'});
        }
    });

});

jQuery(function($){
    "use strict"
    var notificationsWrapper   = $('.dropdown-notifications');
    var notificationsToggle    = notificationsWrapper.find('a[data-toggle]');
    var notificationsCountElem = notificationsToggle.find('.notification-icon');
    var notificationsCount     = parseInt(notificationsCountElem.html());
    var notifications          = notificationsWrapper.find('ul.dropdown-list-items');

    if(superio.pusher_api_key && superio.pusher_cluster){
        var pusher = new Pusher(superio.pusher_api_key, {
            encrypted: true,
            cluster: superio.pusher_cluster
        });
    }

    $(document).on("click",".markAsRead",function(e) {
        e.stopPropagation();
        e.preventDefault();
        var id = $(this).data('id');
        var url = $(this).attr('href');
        $.ajax({
            url: superio.markAsRead,
            data: {'id' : id },
            method: "post",
            success:function (res) {
                window.location.href = url;
            }
        })
    });
    $(document).on("click",".markAllAsRead",function(e) {
        e.stopPropagation();
        e.preventDefault();
        $.ajax({
            url: superio.markAllAsRead,
            method: "post",
            success:function (res) {
                $('.dropdown-notifications').find('li.notification').removeClass('active');
                notificationsCountElem.text(0);
                notificationsWrapper.find('.notif-count').text(0);
            }
        })
    });

    var callback = function(data) {
        var existingNotifications = notifications.html();
        var newNotificationHtml = '<li class="notification active">'
            +'<div class="media">'
            +'    <div class="media-left">'
            +'      <div class="media-object">'
            +  data.avatar
            +'      </div>'
            +'    </div>'
            +'    <div class="media-body">'
            +'      <a class="markAsRead p-0" data-id="'+data.idNotification+'" href="'+data.link+'">'+data.message+'</a>'
            +'      <div class="notification-meta">'
            +'        <small class="timestamp">about a few seconds ago</small>'
            +'      </div>'
            +'    </div>'
            +'  </div>'
            +'</li>';
        notifications.html(newNotificationHtml + existingNotifications);

        notificationsCount += 1;
        notificationsCountElem.text(notificationsCount);
        notificationsWrapper.find('.notif-count').text(notificationsCount);
    };

    if(superio.isAdmin > 0 && superio.pusher_api_key){
        var channel = pusher.subscribe('admin-channel');
        channel.bind('App\\Events\\PusherNotificationAdminEvent', callback);
    }

    if(superio.currentUser > 0 && superio.pusher_api_key){
        var channelPrivate = pusher.subscribe('user-channel-'+superio.currentUser);
        channelPrivate.bind('App\\Events\\PusherNotificationPrivateEvent', callback);
    }
    $(document).on("click",".sidebar-column .btn-send-message",function(e) {
        e.preventDefault();
        $([document.documentElement, document.body]).animate({
            scrollTop: $(".contact-widget").offset().top
        }, 2000);
    });
});


