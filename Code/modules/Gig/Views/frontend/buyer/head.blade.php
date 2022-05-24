<section class="page-title">
    <div class="auto-container">
        <div class="title-outer">
            <h1>{{__("My Gig Orders")}}</h1>
        </div>
    </div>
</section>
<div class="auto-container">
    <div class="mt-3 mb-5">
        <div class="default-tabs style-two tabs-box">
            <ul class="tab-buttons clearfix">

                <li class="@if(request()->get('status') == \Modules\Gig\Models\GigOrder::INCOMPLETE) active-btn @endif"><a href="{{ route('buyer.orders',['status'=>\Modules\Gig\Models\GigOrder::INCOMPLETE]) }}">{{__("Incomplete")}}</a></li>
                <li class="@if(request()->get('status') == \Modules\Gig\Models\GigOrder::IN_PROGRESS) active-btn @endif"><a href="{{ route('buyer.orders',['status'=>\Modules\Gig\Models\GigOrder::IN_PROGRESS]) }}">{{__("In Progress")}}</a></li>

                <li class="@if(request()->get('status') == \Modules\Gig\Models\GigOrder::DELIVERED) active-btn @endif"><a href="{{ route('buyer.orders',['status'=>\Modules\Gig\Models\GigOrder::DELIVERED]) }}">{{__("Delivered")}}</a></li>
                <li class="@if(request()->get('status') == \Modules\Gig\Models\GigOrder::IN_REVISION) active-btn @endif"><a href="{{ route('buyer.orders',['status'=>\Modules\Gig\Models\GigOrder::IN_REVISION]) }}">{{__("In Revision")}}</a></li>
                <li class="@if(request()->get('status') == \Modules\Gig\Models\GigOrder::COMPLETED) active-btn @endif"><a href="{{ route('buyer.orders',['status'=>\Modules\Gig\Models\GigOrder::COMPLETED]) }}">{{__("Completed")}}</a></li>
                <li class="@if(request()->get('status') == \Modules\Gig\Models\GigOrder::CANCELLED) active-btn @endif"><a href="{{ route('buyer.orders',['status'=>\Modules\Gig\Models\GigOrder::CANCELLED]) }}">{{__("Cancelled")}}</a></li>
                <li class="@if(request()->get('status') == '') active-btn @endif"><a href="{{route('buyer.orders')}}">{{__("All")}}</a></li>
            </ul>
        </div>
    </div>
</div>
