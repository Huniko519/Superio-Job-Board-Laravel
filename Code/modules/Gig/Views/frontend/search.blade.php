@extends('layouts.app')
@section('head')
    <link href="{{ asset('dist/frontend/module/gig/css/gig.css?_ver='.config('app.version')) }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset("libs/ion_rangeslider/css/ion.rangeSlider.min.css") }}"/>
@endsection
@section('content')

    <!--Page Title-->
    <section class="page-title">
        <div class="auto-container">
            <div class="title-outer">
                <h1>{{$page_title}}</h1>
                <ul class="page-breadcrumb">
                    <li><a href="{{ home_url() }}">{{ __("Home") }}</a></li>
                    <li>{{ __("Gigs") }}</li>
                </ul>
            </div>
        </div>
    </section>
    <!--End Page Title-->
    <div class="gig_category_level1">
        <div class="auto-container">
            <div class="mt-5">
                <div class="ls-outer mb-4">
                    @include('Gig::frontend.search.filter')
                    @if($rows->isNotEmpty())
                        <div class="row mb-5">
                            @foreach($rows as $row)
                                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4">
                                    @include('Gig::frontend.search.loop')
                                </div>
                            @endforeach
                        </div>
                        <div class="ls-pagination">
                            {{$rows->appends(request()->query())->links()}}
                        </div>
                    @else
                        <div class="gig-results-not-found text-center pt-5 pb-5">
                            <h3>{{ __("No gig results found") }}</h3>
                        </div>

                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script type="text/javascript" src="{{ asset("libs/ion_rangeslider/js/ion.rangeSlider.min.js") }}"></script>
    <script type="text/javascript" src="{{ asset('module/gig/js/gig.js?_ver='.config('app.version')) }}"></script>
@endsection
