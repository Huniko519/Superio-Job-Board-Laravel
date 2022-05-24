@extends('layouts.app')
@section('head')
    <link href="{{ asset('dist/frontend/module/booking/css/checkout.css?_ver='.config('app.version')) }}" rel="stylesheet">
@endsection
@section('content')
    <div class="bravo-booking-page padding-content ">
        <div class="bg-gray space-2">
            <div class="container">
                <div class="row booking-success-notice">
                    <div class="col-lg-8 col-xl-9">
                        <div class="mb-5 shadow-soft bg-white rounded-sm">
                            <div class="py-6 px-5 border-bottom">
                                <div class="flex-horizontal-center">
                                    <div class="height-50 width-50 flex-shrink-0 flex-content-center bg-primary rounded-circle">
                                        <i class="flaticon-tick text-white font-size-24"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="font-size-18 font-weight-bold text-dark mb-0 text-lh-sm">
                                            {{ __("Thank You. Your Booking Order is Confirmed Now.") }}
                                        </h3>
                                        <p class="mb-0">
                                            {{__('Booking details has been sent to:')}} <span>{{$booking->email}}</span>
                                        </p>
                                        @if($note = $gateway->getOption("payment_note"))
                                            <p class="mb-0">
                                                {!! clean($note) !!}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @include ($service->booking_customer_info_file ?? 'Booking::frontend/booking/booking-customer-info')
                            <div class="text-right py-4 pr-4">
                                <a href="{{route('user.booking_history')}}" class="btn btn-primary rounded-sm transition-3d-hover font-size-16 font-weight-bold py-3">{{__('Booking History')}}</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xl-3">
                        @include ($service->checkout_booking_detail_file ?? '')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
@endsection
