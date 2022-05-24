@extends('layouts.app')
@section('head')

@endsection
@section('content')
    @include('Company::frontend.layouts.search.'. $style)
@endsection
@section('footer')
    <script type="text/javascript" src="{{ asset('module/companies/js/companies.js?_ver='.config('app.version')) }}"></script>
@endsection

