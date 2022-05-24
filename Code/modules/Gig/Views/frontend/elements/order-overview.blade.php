<div class="bc-order-overview">
    <h2 class="title">{{ __("Order Details") }}</h2>
    <div class="order-gig-item">
        <div class="thumb">
            @if($order->gig->image_id)
                {!! get_image_tag($order->gig->image_id,'full',['alt'=>$order->gig->title]) !!}
            @endif
        </div>
        <div class="caption">
            <h3 class="gig-title">
                <a href="{{ $order->gig->getDetailUrl() }}" target="_blank">{{ $order->gig->title }}</a>
            </h3>
            <span class="status-label {{ $order->status }}">{{ $order->status_text }}</span>
        </div>
    </div>
    <ul class="order-list-details">
        <li>
            <span class="lb">{{ __("Ordered from") }}</span>
            <span class="val"><a href="#">{{ $order->customer->getDisplayName() }}</a></span>
        </li>
        <li>
            <span class="lb">{{ __("Delivery date") }}</span>
            <span class="val">{{ date('M d, h:i A', strtotime($order->delivery_date)) }}</span>
        </li>
        <li>
            <span class="lb">{{ __("Package") }}</span>
            <span class="val">{{ package_key_to_name($order->package)}}</span>
        </li>
        @if(!empty($order->extra_prices))
            <li>
                <span class="lb">{{ __("Extra Prices:") }}</span>
            </li>
            @foreach($order->extra_prices as $item)
                <li>
                    <span class="lb">{{ $item['name'] ?? '' }}</span>
                    <span class="val">{{ format_money($item['price'])}}</span>
                </li>
            @endforeach
        @endif
        <li>
            <span class="lb">{{ __("Total price") }}</span>
            <span class="val">{{ format_money($order->total)}}</span>
        </li>
        <li>
            <span class="lb">{{ __("Order number") }}</span>
            <span class="val">#{{ $order->id }}</span>
        </li>
    </ul>
</div>
