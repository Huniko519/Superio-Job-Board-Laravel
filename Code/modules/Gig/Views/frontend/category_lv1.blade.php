@extends('layouts.app')
@section('head')
    <link href="{{ asset('dist/frontend/module/gig/css/gig.css?_ver='.config('app.version')) }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset("libs/ion_rangeslider/css/ion.rangeSlider.min.css") }}"/>
@endsection
@section('content')
    <div class="gig_category_level1">
        <div class="auto-container pt-5">
            @if($category->image_id)
                <div class="category-banner bg-cover border-radius-8 mb-5 " style="background-image: url('{{get_file_url($category->image_id,'full')}}')">
                    <div class="row h-100">
                        <div class="col-md-3"></div>
                        <div class="col-md-6 d-flex align-items-center flex-column justify-content-center">
                            <h1 class="title c-white mb-3 fw-500">{{$translation->name}}</h1>
                            <p class="subtitle c-white mb-0 text-center">{{$translation->content}}</p>
                        </div>
                    </div>
                </div>
            @endif
            @include('Gig::frontend.search.popular')
            @include('Gig::frontend.search.types')
            @include('Gig::frontend.search.news')
        </div>
            @include('Gig::frontend.search.faqs')
        <div class="auto-container">
            @include('Gig::frontend.search.related')
        </div>
    </div>
@endsection

@section('footer')
    <script type="text/javascript" src="{{ asset("libs/ion_rangeslider/js/ion.rangeSlider.min.js") }}"></script>
    <script type="text/javascript" src="{{ asset('module/gig/js/gig.js?_ver='.config('app.version')) }}"></script>
@endsection
