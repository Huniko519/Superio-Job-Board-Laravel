@extends("Layout::app")
@section('content')
    <div class="breadcrumb_area_three">
        <div class="container">
            <div class="breadcrumb_text min-w-80">
                <h2 class="fs-40 lh-normal">{{__("Cart")}}</h2>
            </div>
        </div>
    </div>
    <section class="page_breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-sm-7">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">{{__("Home")}}</a></li>
                            <li class="breadcrumb-item"><a href="{{route('product.index')}}">{{__("All Products")}}</a></li>
                            <li class="breadcrumb-item active">{{__("Cart")}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <div class="container pt-5 pb-5">
    @if(\Modules\Order\Helpers\CartManager::count())
        <div class="row">
            <div class="col-md-12 col-lg-8 col-xl-8">
                <div class="booking-form">
                    @include ('Order::frontend.cart.form')
                </div>
            </div>
            <div class="col-lg-4 col-xl-4">
                <div class="booking-detail">
                    <h3>Total: {{format_money(\Modules\Order\Helpers\CartManager::subtotal())}}</h3>
                    <div class="ui_kit_button payment_widget_btn">
                        <a href="{{route('checkout')}}" class="btn btn-primary btn-block">{{__('Proceed To Checkout') }}</a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-warning">{{__("Your cart is empty!")}}</div>
    @endif
    </div>
@endsection
@section('footer')
    <script>
        $(document).on('click', '.bravo_delete_cart_item', function(e) {
            e.preventDefault();
            var c = confirm('{{__('Do you want to delete?')}}');
            if (!c)
                return;
            var me = $(this);
            var id = $(this).data('id');
            $.ajax({
                url: '{{route('cart.remove_cart_item')}}',
                data: {
                    id: id
                },
                type: 'post',
                dataType: 'json',
                success: function(json) {
                    if (json.fragments) {
                        for (var k in json.fragments) {
                            $(k).html(json.fragments[k]);
                        }
                    }
                    if (json.url) {
                        window.location.href = json.url;
                    }
                    if (json.reload) {
                        window.location.reload();
                    }
                    if (json.message) {
                        bookingCoreApp.showAjaxMessage(json);
                    }
                },
                error: function(err) {
                    bravo_handle_error_response(err);
                    console.log(err)
                }
            })
        })
    </script>
@endsection
