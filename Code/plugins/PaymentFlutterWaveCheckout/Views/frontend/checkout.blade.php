<style>
    .checkout-button{
        background: {{setting_item('style_main_color','#5191fa')}};
        margin: 2rem auto;
        padding: 1rem;
        color: #fff;
        border: 1px solid;
        border-radius: 0.25rem;
        display: flex;
    }
    
</style>

<form class="text-center py-5">
    <script src="https://checkout.flutterwave.com/v3.js"></script>
    <button type="button" class="checkout-button" onClick="makePayment()">{{__("Pay Now")}}</button>
</form>
<script>
    function makePayment() {
        FlutterwaveCheckout({
            public_key: "{{$data['public_key']}}",
            tx_ref: "{{$data['tx_ref']}}",
            amount: {{$data['amount']}},
            currency: "{{$data['currency']}}",
            // country: "US",
            payment_options: "1",
            customer: {
                email: "{{$payment->order->customer->email??""}}",
                phone_number: "{{$payment->order->billing['phone']??""}}",
                name: "{{__(':first_name :last_name',['first_name'=>$payment->order->billing['first_name']??"",'last_name'=>$payment->order->billing['last_name']??""])}}",
            },
            redirect_url:'{{route('confirmFlutterWaveGateway',['payment_id'=>$payment->id])}}',
            onclose: function() {
                window.location.href="{{$payment->getDetailUrl()}}"
            },
            customizations: {
                title: "{{$data['service_title']}}",
                description: "{{$data['description']}}",
                logo: "",
            },
        });
    }
</script>
