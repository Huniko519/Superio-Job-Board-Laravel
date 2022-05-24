@extends("Layout::app")
@section('head')
    <link rel="stylesheet" href="{{asset('dist/frontend/module/order/css/checkout.css?_v='.config('app.asset_version'))}}">
@endsection
@section('content')
    <section class="page-title">
        <div class="auto-container">
            <div class="title-outer">
                <h1>{{__('Checkout')}}</h1>
                <ul class="page-breadcrumb">
                    <li><a href="{{route('home')}}">{{__('Home')}}</a></li>
                    <li>{{__('Checkout')}}</li>
                </ul>
            </div>
        </div>
    </section>
    <div class="checkout-page" id="bravo-checkout-page" v-cloak>
        <div class="auto-container">
            @if(\Modules\Order\Helpers\CartManager::count())
            <div class="row">
                <div class="column col-lg-8 col-md-12 col-sm-12">
                    @include ('Order::frontend.checkout.billing')
                </div>
                <div class="column col-lg-4 col-md-12 col-sm-12">
                    @include ('Order::frontend.checkout.review')
                    <div class="payment-box">
                        <div class="payment-options">
                            @include ('Order::frontend.checkout.payment')
                            <hr>
                            @php
                                $term_conditions = setting_item('booking_term_conditions');
                            @endphp

                            <div class="form-group">
                                <label class="term-conditions-checkbox">
                                    <input type="checkbox" name="term_conditions"> {{__('I have read and accept the')}}  <a target="_blank" href="{{get_page_url($term_conditions)}}">{{__('terms and conditions')}}</a>
                                </label>
                            </div>
                            @if(setting_item("booking_enable_recaptcha"))
                                <div class="form-group">
                                    {{recaptcha_field('booking')}}
                                </div>
                            @endif
                            <div class="html_before_actions"></div>

                            <p class="alert mt10" v-show=" message.content" v-html="message.content" :class="{'alert-danger':!message.type,'alert-success':message.type}"></p>

                            <div class="form-actions btn-box">
                                <button class="theme-btn btn-style-one btn-block" @click="doCheckout">{{__('Place Order')}}
                                    <i class="fa fa-spin fa-spinner" v-show="onSubmit"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @else
                <div class="alert alert-warning">{{__("Your cart is empty!")}}</div>
            @endif
        </div>
    </div>
@endsection
@section('footer')
    <script src="{{ asset('module/order/js/checkout.js') }}"></script>
    <script type="text/javascript">

    </script>
@endsection
