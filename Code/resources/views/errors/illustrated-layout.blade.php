@extends('layouts.app')
@section('head')

@endsection
@section('content')
    <div class="mb-8 bc-page-404">
        <div class="auto-container">
            <div class="row mb-5 mb-md-7 mb-lg-0">
                <div class="col-lg-5 col-xl-3dot5">
                    <div class="space-lg-1 space-xl-3 mt-xl-2 mb-5 mb-md-7 mb-lg-0">
                        <div class="font-weight-bold on-no-text">@yield('code', __('Oh no'))</div>
                        <h6 class="title-404">
                            @yield('title')
                        </h6>
                        <p class="error-desc">
                            @yield('message')
                        </p>
                        <a href="{{ url('/') }}" class="btn btn-primary rounded-xs transition-3d-hover font-weight-bold min-width-190 min-height-60 d-inline-flex flex-content-center">
                            {{ __("Back to Home") }}
                        </a>
                    </div>
                </div>
                <div class="col-lg-7 col-xl-8dot5">
                    <div class="space-lg-2 space-xl-3 mt-lg-5 mt-xl-7">
                        <img src="@yield('image')" alt="@yield('code', __('Oh no'))">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')

@endsection
