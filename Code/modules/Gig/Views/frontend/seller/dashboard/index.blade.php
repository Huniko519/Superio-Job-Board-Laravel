@extends('layouts.app')
@section("head")
    <link href="{{ asset('dist/frontend/module/gig/css/gig.css?_ver='.config('app.version')) }}" rel="stylesheet">
@endsection
@section('content')
    <section class="page-title">
        <div class="auto-container">
            <div class="title-outer">
                <h1>{{ __("Seller Dashboard") }}</h1>
            </div>
        </div>
    </section>
    <section class="ls-section seller-dashboard">
        <div class="auto-container">
            <div class="filters-backdrop"></div>
            <div class="row">
                <!-- Filters Column -->
                <div class="filters-column col-lg-4 col-md-12 col-sm-12">
                    @include('Gig::frontend.seller.dashboard.profile')
                </div>
                <!-- Content Column -->
                <div class="content-column col-lg-8 col-md-12 col-sm-12">
                    <div class="ls-outer">
                        <button type="button" class="theme-btn btn-style-two toggle-filters">{{__("Show Filters")}}</button>
                        <!-- ls Switcher -->
                        <div class="ls-switcher">
                            <div class="showing-result">
                                <div class="text">{{ __("Showing :from - :to of :total",["from"=>$rows->firstItem(),"to"=>$rows->lastItem(),"total"=>$rows->total()]) }}</div>
                            </div>
{{--                            @include('Company::frontend.layouts.search.company-sort')--}}
                        </div>
                        <!-- Block Block -->
                        @if($rows->count() > 0)
                            @foreach($rows as $row)
                                @include('Gig::frontend.seller.dashboard.item')
                            @endforeach
                        @else
                            <div class="alert alert-danger">
                                {{__("Sorry, but nothing matched your search terms. Please try again with some different keywords.")}}
                            </div>
                        @endif
                        <div class="ls-pagination">
                            {{$rows->appends(request()->query())->links()}}
                            @if($rows->total() > 0)
                                <span class="count-string">{{ __("Showing :from - :to of :total",["from"=>$rows->firstItem(),"to"=>$rows->lastItem(),"total"=>$rows->total()]) }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
