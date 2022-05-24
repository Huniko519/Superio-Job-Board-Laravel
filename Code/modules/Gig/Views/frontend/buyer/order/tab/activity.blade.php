@php
    $item_date = date('M d', strtotime($order->created_at));
    $delivery_count = 0;
@endphp
<div class="bc-order-panel @if($order->status == \Modules\Gig\Models\GigOrder::COMPLETED || $order->status == \Modules\Gig\Models\GigOrder::CANCELLED) bc-order-completed @endif">
    <div class="order-activity-list">
        <div class="activity-date">
            {{ $item_date }}
        </div>
        <div class="activity-item placed-order">
            <div class="avatar type-icon">
                <i class="icon la la-file-o"></i>
            </div>
            <div class="item-body">
                <div class="item-title">
                    {{ __("You placed the order") }} <span class="activity-time">{{ date('M d, h:i A', strtotime($order->created_at)) }}</span>
                </div>
            </div>
        </div>
        @if($order->activities)
            @foreach($order->activities as $key => $activity)
                @php
                    $item_c_date = date('M d', strtotime($activity->created_at));
                @endphp
                @if($item_date != $item_c_date)
                    @php $item_date = $item_c_date @endphp
                    <div class="activity-date">
                        {{ $item_date }}
                    </div>
                @endif
                @switch($activity['type'])
                    @case(\Modules\Gig\Models\GigOrderActivity::TYPE_REQUIREMENTS)
                        <div id="activity-{{ $activity->id }}" class="activity-item requirements">
                            <div class="avatar type-icon">
                                <i class="icon la la-pencil-alt"></i>
                            </div>
                            <div class="item-body">
                                <div class="item-title">
                                    {{ __("You submitted the requirements") }} <span class="activity-time">{{ date('M d, h:i A', strtotime($activity->created_at)) }}</span>
                                </div>
                            </div>
                        </div>
                        @break
                    @case(\Modules\Gig\Models\GigOrderActivity::TYPE_ORDER_STARTED)
                        <div id="activity-{{ $activity->id }}" class="activity-item order-started">
                            <div class="avatar type-icon">
                                <i class="icon la la-rocket"></i>
                            </div>
                            <div class="item-body">
                                <div class="item-title">
                                    {{ __("Your order started") }} <span class="activity-time">{{ date('M d, h:i A', strtotime($activity->created_at)) }}</span>
                                </div>
                            </div>
                        </div>
                        @break
                    @case(\Modules\Gig\Models\GigOrderActivity::TYPE_DELIVERY_DATE)
                        <div id="activity-{{ $activity->id }}" class="activity-item delivery-date">
                            <div class="avatar type-icon">
                                <i class="icon la la-clock"></i>
                            </div>
                            <div class="item-body">
                                <div class="item-title">
                                    {{ __("Your delivery date was updated to") }} {{ date('M d', strtotime($order->delivery_date)) }}<span class="activity-time">{{ date('M d, h:i A', strtotime($activity->created_at)) }}</span>
                                </div>
                            </div>
                        </div>
                        @break
                    @case(\Modules\Gig\Models\GigOrderActivity::TYPE_DELIVERED)
                        @php $delivery_count++; @endphp
                        <div id="activity-{{ $activity->id }}" class="activity-item delivered">
                            <div class="avatar type-icon">
                                <i class="icon la la-luggage-cart"></i>
                            </div>
                            <div class="item-body">
                                <div class="item-title">
                                    <a href="#">{{ $activity->user->getDisplayName() }}</a> {{ __("delivered your order") }}
                                    <span class="activity-time">{{ date('M d, h:i A', strtotime($activity->created_at)) }}</span>
                                </div>
                                <div class="message-body">
                                    @include('Gig::frontend.elements.delivery-item')
                                </div>
                            </div>
                        </div>
                        @break
                    @case(\Modules\Gig\Models\GigOrderActivity::TYPE_REVISION)
                        <div id="activity-{{ $activity->id }}" class="activity-item revision">
                            <div class="avatar type-icon">
                                <i class="icon la la-refresh"></i>
                            </div>
                            <div class="item-body">
                                <div class="item-title">
                                     {{ __("Your requested a revision") }}
                                    <span class="activity-time">{{ date('M d, h:i A', strtotime($activity->created_at)) }}</span>
                                </div>
                                <div class="message-body">
                                    <div class="delivery-item">
                                        <div class="delivery-heading">
                                            {{ __("REVISION REQUEST") }}
                                        </div>
                                        <div class="delivery-body">
                                            <div class="activity-item user-message">
                                                <div class="avatar type-text">
                                                    {!! ($activity->user->getUserAvatar('text')) !!}
                                                </div>
                                                <div class="item-body">
                                                    <div class="item-title">
                                                        {{ __("Me") }}
                                                    </div>
                                                    <div class="message-body">
                                                        {!! @clean($activity->content) !!}
                                                        @include('Gig::frontend.elements.attachments')
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @break
                    @case(\Modules\Gig\Models\GigOrderActivity::TYPE_ORDER_COMPLETED)
                        <div id="activity-{{ $activity->id }}" class="activity-item order-completed">
                            <div class="avatar type-icon">
                                <i class="icon la la-file-o"></i>
                            </div>
                            <div class="item-body">
                                <div class="item-title">
                                    {{ __("You order was completed") }} <span class="activity-time">{{ date('M d, h:i A', strtotime($activity->created_at)) }}</span>
                                </div>
                            </div>
                        </div>
                        @break
                    @default
                        <div id="activity-{{ $activity->id }}" class="activity-item user-message">
                            <div class="avatar type-image">
                                {!! ($activity->user->getUserAvatar('text')) !!}
                            </div>
                            <div class="item-body">
                                <div class="item-title">
                                    @if(auth()->id() == $activity->user_id)
                                        {{ __("Me") }}
                                    @else
                                        <a href="#">{{ $activity->user->getDisplayName() }}</a>
                                    @endif
                                        <span class="activity-time">{{ date('M d, h:i A', strtotime($activity->created_at)) }}</span>
                                </div>
                                <div class="message-body">
                                    {!! @clean($activity->content) !!}
                                    @include('Gig::frontend.elements.attachments')
                                </div>
                            </div>
                        </div>
                        @break
                @endswitch
            @endforeach
        @endif

    </div>

    @if($order->status == \Modules\Gig\Models\GigOrder::COMPLETED || $order->status == \Modules\Gig\Models\GigOrder::CANCELLED)
        <div class="order-bottom-status {{ $order->status }}">
            <div class="activity-item user-message">
                <div class="avatar type-text">
                    {!! $order->customer->getUserAvatar('text') !!}
                </div>
                <div class="item-body">
                    <div class="item-title">
                        @if($order->status == 'cancelled')
                            {{ __("Your order is cancel.") }}
                        @else
                            {{ __("Your order is complete.") }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@if($order->status == \Modules\Gig\Models\GigOrder::DELIVERED)
    <div class="button-group text-center mt-4">
        <a class="theme-btn btn-style-one bg-blue mr-3 accept-order"
           data-confirm="{{ __("Do you want to accept the order?") }}"
           href="{{ route('buyer.accept_order', ['id' => $order->id]) }}">{{ __("Accept") }}</a>
        @if(!$order->orderExpired())
            <a class="theme-btn btn-style-one bg-blue bc-request-vision" href="#">{{ __("Request A Revision") }}</a>
            @include('Gig::frontend.elements.revision-popup')
        @endif
    </div>
@endif

@if($order->status != \Modules\Gig\Models\GigOrder::COMPLETED && $order->status != \Modules\Gig\Models\GigOrder::CANCELLED)
    <div class="bc-order-panel">
        <form class="send-message-form" action="{{ route('buyer.send_message') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="order_id" value="{{ $order->id }}">
            <div class="form-group">
                <label id="message">{{ __("Message") }}</label>
                <textarea id="message" required class="form-control" name="content" rows="5" placeholder="{{ __("Type your message here...") }}"></textarea>
            </div>
            <div class="form-group">
                <div class="attach-file">
                    <label> {{ __("Attach File (optional)") }} </label>
                    <input type="file" name="files[]" accept="image/*" multiple class="form-control-file">
                </div>
                <p><i>{{__("Maximum 4 files, image only")}}</i></p>
            </div>
            <div class="text-right">
                <button type="submit" class="theme-btn btn-style-one bg-blue">{{ __("Send") }}</button>
            </div>
        </form>
    </div>
@endif
