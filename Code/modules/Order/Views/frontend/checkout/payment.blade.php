<ul >
    @foreach($gateways as $k=>$gateway)
        <li>
            <div class="radio-option radio-box">
                <input type="radio" name="payment_gateway" value="{{$k}}" id="payment-{{$k}}" >
                <label for="payment-{{$k}}">
                    @if($logo = $gateway->getDisplayLogo())
                        <img src="{{$logo}}" alt="{{$gateway->getDisplayName()}}">
                    @endif
                    {{$gateway->getDisplayName()}}
                </label>
                <div class="gateway_html">
                    {!! $gateway->getDisplayHtml() !!}
                </div>
            </div>
        </li>
    @endforeach
</ul>
