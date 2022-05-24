@extends('layouts.app')

@section('content')
<div class="page-profile-content page-template-content">
    <div class="container">
        <div class="">
            <div class="row">
                <div class="col-md-4">
                    @include('User::frontend.profile.sidebar')
                </div>
                <div class="col-md-8">
                    @include('User::frontend.profile.services')
                    @include('User::frontend.profile.reviews')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
