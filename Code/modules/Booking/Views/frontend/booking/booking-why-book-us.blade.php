@php $booking_why_book_with_us = setting_item_array('booking_why_book_with_us',[]); @endphp
@if(!empty($booking_why_book_with_us))
    <div class="border border-color-7 rounded p-4 mb-5 mt-5">
        <h6 class="font-size-17 font-weight-bold text-gray-3 mx-1 mb-3 pb-1">
            {{ __("Why Book With Us?") }}
        </h6>
        @foreach($booking_why_book_with_us as $key=>$item)
            <div class="d-flex align-items-center mt-3">
                <i class="{{$item['icon'] ?? ""}} font-size-25 text-primary mr-3 pr-1"></i>
                <h6 class="mb-0 font-size-14 text-gray-1">
                    <a href="{{$item['link'] ?? ""}}">{{$item['title'] ?? ""}}</a>
                </h6>
            </div>
        @endforeach
    </div>
@endif
