@extends('layouts.user')
@section('head')
    <link href="{{ asset('module/user/css/user.css') }}" rel="stylesheet">
@endsection
@section('content')
    <h3 class="title py-4">
        {{__("Change Password")}}
    </h3>
    @include('admin.message')
    <form action="{{ route("user.change_password.update") }}" method="post" class="default-form pb-4">
        @csrf
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="panel">
                    <div class="panel-title"><strong>{{ __('Change Password') }}</strong></div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label>{{__("Current Password")}}</label>
                            <input type="password" name="current-password" placeholder="{{__("Current Password")}}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>{{__("New Password")}}</label>
                            <input type="password" name="new-password" placeholder="{{__("New Password")}}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>{{__("New Password Again")}}</label>
                            <input type="password" name="new-password_confirmation" placeholder="{{__("New Password Again")}}" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <hr>
                <input type="submit" class="btn btn-primary" value="{{__("Change Password")}}">
                <a href="{{ route("user.profile.index") }}" class="btn btn-default">{{__("Cancel")}}</a>
            </div>
        </div>
    </form>
@endsection
@section('footer')

@endsection
