@extends('layouts.app')
@section('head')

@endsection
@section('content')
    <section class="pricing-section">
        <div class="auto-container">
            @include('admin.message')
            @include('User::frontend.plan.list')
        </div>
    </section>
@endsection
@section('footer')
@endsection
