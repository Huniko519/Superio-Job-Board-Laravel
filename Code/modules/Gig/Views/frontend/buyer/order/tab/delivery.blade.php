@php
    $delivery_count = 0;
@endphp
<div class="bc-order-panel delivery-tab">
    <div class="order-activity-list">
        @if($order->delivery)
            @foreach($order->delivery as $key => $activity)
                @php $delivery_count++; @endphp
                @include('Gig::frontend.elements.delivery-item')
            @endforeach
        @endif
    </div>
</div>
