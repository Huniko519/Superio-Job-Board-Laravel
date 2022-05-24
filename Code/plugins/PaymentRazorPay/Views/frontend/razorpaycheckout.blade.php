<script src="{{ asset('libs/jquery-3.6.0.min.js') }}"></script>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    let $currency = '{{ strtoupper($payment['currency']) }}';
    let $amount = '{{ $payment['amount'] }}';
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });
    var options = {
        "key": "{{ $key }}",
        "amount": {{ ($payment['converted_amount'] > 0) ? ($payment['converted_amount'] * 100) :
        $payment['amount'] * 100 }},

        "currency": "{{($payment['converted_currency'] != '') ? strtoupper($payment['converted_currency']) : strtoupper($payment['currency'])}}",
        "name": '{{ setting_item("site_title")." - #".$payment->id }}',
        "description": '{{ setting_item("site_title")." - #".$payment->id }}',
        "image": "",
        "order_id": "{{ $r }}",
        "handler": function (response){
                let data = response;
                data['_token'] = '{{ csrf_token() }}'
            $.ajax({
                url: '{{ $form_url }}',
                type: 'post',
                data: data,
                datatype: 'JSON',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function (msg) {
                    window.location.href = msg;
                }
            });
        },
        "prefill": {
            "name": "{{ $payment->first_name . ' ' . $payment->last_name }}",
            "email": "{{ $payment->email }}",
            "contact": ""
        },
        "notes": {
            "address": ""
        },
        "modal": {
            "ondismiss": function(){
                window.location.replace("{{ $cancelUrl }}");
            }
        }
    };
    if($currency != 'INR')
    {
        options['display_amount'] = $amount;
        options['display_currency'] = $currency;
    }
    var rzp1 = new Razorpay(options);
    rzp1.open();
</script>
