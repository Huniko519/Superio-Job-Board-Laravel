<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"><head>
    <meta charset="utf-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
    <title>Superio - Job Board HTML Template</title>

    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu:400,500,700&display=swap" rel="stylesheet">
    <link href="{{asset('landing')}}/bootstrap/bootstrap.css" rel="stylesheet" type="text/css">

    <link href="{{asset('landing')}}/css/style.css" rel="stylesheet" type="text/css">
    <link href="{{asset('landing')}}/css/css.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="{{asset('landing')}}/js/jquery.js"></script>
    <script type="text/javascript" src="{{asset('landing')}}/bootstrap/bootstrap.min.js"></script>
    <script type="text/javascript" src="{{asset('landing')}}/js/main.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function($){
            if (window!=window.top) {
                window.top.location.href = window.location.href;
            }
        });
    </script>
    <link rel="stylesheet" type="text/css" href="{{asset('landing')}}/css/slick.css"/>
    <link rel="stylesheet" type="text/css" href="{{asset('landing')}}/css/slick-theme.css"/>
    <!-- <script src="js/wow.min.js"></script> -->
    <script>
        new WOW().init();
    </script>
</head>
<body data-spy="scroll" data-target=".navbar" data-offset="50">
<header class="apus-header">
    <div class="header-full">
        <div class="container-fluid">
            <div class="row flex-middle-sm">
                <div class="col-sm-3 col-xs-12">
                    <div class="logo">
                        <img alt="" src="{{ asset('landing') }}/images/logo.png">
                    </div>
                </div>
                <div class="col-sm-9 col-xs-12">
                    <div class="flex-middle-sm justify-end">
                        <nav class="navbar navbar-inverse text-center">
                            <ul class="menu nav navbar-nav">
                                <li> <a href="#home-pages" title="">Demo</a> </li>
                                <li> <a href="#listing" title="">Job Layout </a> </li>
                                <li> <a href="#listing-detail" title="">Job Detail</a> </li>
                                <li> <a href="#dashboard" title="">Dashboard</a> </li>
                            </ul>
                        </nav>
                        <div class="buy pull-right hidden-xs">
                            <a class="btn btn-theme-second pull-right" target="_blank" href="#">Purchase Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<div id="wrapper">
    <div class="main-content">

        <div class="topheader clearfix">
            <div class="topheader-inner">
                <div class="container text-center">
                    <h3 class="title-top text-white">The All-In-One <span class="text-theme-second">Job Board</span><br>HTML Template</h3>
                    <div class="button-top">
                        <a href="#" class="btn btn-white">View Demos</a>
                    </div>
                </div>
            </div>
        </div>

        <div id="home-pages" class="section1 home-pages">
            <div class="container">
                <div class="top-wrapper text-center">
                    <h2 class="text-theme number-homes">10+</h2>
                    <h3 class="title">Homepage Demos </h3>
                    <div class="des">View our high quality & eye catching website demos; Job Board feature-rich template is the perfect one.</div>
                </div>
                <div class="row row-90">
                    <div class="col-xs-12 col-md-4 col-sm-6 wow slideInLeft">
                        <div class="wrap-img wrap-img ">
                            <a class="img-bg" href="{{ url('/') }}" target="_blank">
                                <img src="{{ asset('landing') }}/images/home-1.png">
                            </a>
                            <h3 class="title-demo"><a href="{{ url('/') }}">Demo 1</a></h3>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-4 col-sm-6 wow slideInLeft">
                        <div class="wrap-img wrap-img ">
                            <a class="img-bg" href="{{ url('/page/home-page-2') }}" target="_blank">
                                <img src="{{ asset('landing') }}/images/home-2.png">
                            </a>
                            <h3 class="title-demo"><a href="{{ url('/page/home-page-2') }}">Demo 2</a></h3>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-4 col-sm-6 wow slideInLeft">
                        <div class="wrap-img wrap-img ">
                            <a class="img-bg" href="{{ url('/page/home-page-3') }}" target="_blank">
                                <img src="{{ asset('landing') }}/images/home-3.png">
                            </a>
                            <h3 class="title-demo"><a href="{{ url('/page/home-page-3') }}">Demo 3</a></h3>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-4 col-sm-6 wow slideInLeft">
                        <div class="wrap-img wrap-img ">
                            <a class="img-bg" href="{{ url('/page/home-page-4') }}" target="_blank">
                                <img src="{{ asset('landing') }}/images/home-4.png">
                            </a>
                            <h3 class="title-demo"><a href="{{ url('/page/home-page-4') }}">Demo 4</a></h3>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-4 col-sm-6 wow slideInLeft">
                        <div class="wrap-img wrap-img ">
                            <a class="img-bg" href="{{ url('/page/home-page-5') }}" target="_blank">
                                <img src="{{ asset('landing') }}/images/home-5.png">
                            </a>
                            <h3 class="title-demo"><a href="{{ url('/page/home-page-5') }}">Demo 5</a></h3>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-4 col-sm-6 wow slideInLeft">
                        <div class="wrap-img wrap-img ">
                            <a class="img-bg" href="{{ url('/page/home-page-6') }}" target="_blank">
                                <img src="{{ asset('landing') }}/images/home-6.png">
                            </a>
                            <h3 class="title-demo"><a href="{{ url('/page/home-page-6') }}">Demo 6</a></h3>
                        </div>
                    </div>
                </div>

            </div>
        </div>



        <div id="listing" class="section1">
            <div class="container">
                <div class="top-wrapper text-center">
                    <h2 class="number text-white">14+</h2>
                    <h3 class="title text-white">Job List Layouts</h3>
                    <div class="des text-white">A better Superio is out there. We'll help you find it. We're your first step to becoming everything you want to be.</div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="max-850">
                    <div class="slick-class slick-class-style st-white">
                        <div><a class="img-listing" href="{{ url('/job') }}" target="_blank"><img src="{{ asset('landing') }}/images/l1.jpg"></a></div>
                        <div><a class="img-listing" href="{{ url('/job?_layout=v2') }}" target="_blank"><img src="{{ asset('landing') }}/images/l2.jpg"></a></div>
                        <div><a class="img-listing" href="{{ url('/job?_layout=v3') }}" target="_blank"><img src="{{ asset('landing') }}/images/l7.jpg"></a></div>
                    </div>
                </div>
            </div>
        </div>


        <div id="listing-detail" class="section2">
            <div class="container">
                <div class="row flex-middle-sm">
                    <div class="col-xs-12 col-sm-6">
                        <div class="top-wrapper">
                            <h2 class="number text-theme">05+</h2>
                            <h3 class="title">Job Sıngle <span class="text-theme">Layouts</span> </h3>
                            <div class="des">A better Superio is out there. We'll help you find it. We're your first step to becoming everything you want to be.</div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="slick-class slick-class-style">
                            <div><a class="img-listing" href="{{ url('/job/product-designer-ui-designer') }}" target="_blank"><img src="{{ asset('landing') }}/images/d1.jpg"></a></div>
                            <div><a class="img-listing" href="{{ url('job/product-designer-ui-designer?_layout=v2') }}" target="_blank"><img src="{{ asset('landing') }}/images/d2.jpg"></a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="dashboard" class="section2">
            <div class="container">
                <div class="row flex-middle-sm">
                    <div class="col-xs-12 col-sm-6"><img src="{{ asset('landing') }}/images/dashboard.png"></div>
                    <div class="col-xs-12 col-sm-6 right-dashboard">
                        <div class="top-wrapper">
                            <h3 class="title">Front-End User <span class="text-theme">Dashboard</span> </h3>
                            <div class="des">A better Superio is out there. We'll help you find it. We're your first step to becoming everything you want to be.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div id="mobile">
            <div class="container">
                <h3 class="titile-mobile text-white">Mobile Friendly</h3>
                <div class="des-mobile text-white">
                    No reason to worry about the growing mobile device market. Your<br> site will look razor sharp on any device.
                </div>
            </div>
        </div>




    </div>
    <div class="footer">
        <div class="footer-inner">
            <div class="container">
                <div class="text-center">
                    <h3 class="food">Build an amazing job board<br>
                        using Superio today!</h3>
                    <a class="btn btn-theme-second" target="_blank" href="#">Buy Now</a>
                    <div class="footer-bottom">Powered By Made with love by CreativeLayers</div>
                </div>
            </div>
        </div>

    </div>
</div>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="{{asset('landing')}}/js/slick.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.slick-class').slick({
            dots: true,
            infinite: true,
            arrows: false,
            speed: 300,
            slidesToShow: 1,
            slidesToScroll: 1,
            centerPadding: '0px',
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });
    });
</script>
</body>
</html>
