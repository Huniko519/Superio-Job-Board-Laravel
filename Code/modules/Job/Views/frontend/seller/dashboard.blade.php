@extends('layouts.app')

@section('content')
    <div class="blog-single">
        <div class="auto-container">
            <div class="row">
                <div class="col-md-4">
                    @include('Gig::frontend.seller.user')
                </div>
                <div class="col-md-8">
                    @include('Gig::frontend.seller.order')
                </div>
            </div>
        </div>

    </div>
@endsection

@section('footer')
@endsection
