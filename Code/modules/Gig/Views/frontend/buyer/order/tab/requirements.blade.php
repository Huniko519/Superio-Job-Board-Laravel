@php
$requirements = $order->gig->requirements;
if(!empty($order->requirements)){
    $requirements = $order->requirements;
}
@endphp
<div class="bc-order-panel requirements-tab">
    <form class="submit-requirement" action="{{ route('buyer.submit_requirements') }}" method="POST">
        @csrf
        <input type="hidden" name="order_id" value="{{ $order->id }}">
        <div class="bc-list-requirements">
            @foreach($requirements as $key => $val)
                <div class="requirement-item">
                    <span class="index">{{ $key + 1 }}</span>
                    <div class="r-right">
                        @if($order->status == \Modules\Gig\Models\GigOrder::INCOMPLETE)
                            <input type="hidden" name="requirements[{{$key}}][content]" value="{{ $val['content'] ?? '' }}" >
                        @endif
                        <h4 class="question">{{ $val['content'] ?? '' }} @if($order->status == \Modules\Gig\Models\GigOrder::INCOMPLETE && !empty($val['required'])) <span class="text-danger">*</span> @endif</h4>
                            @if($order->status == \Modules\Gig\Models\GigOrder::INCOMPLETE)
                            <div class="answer-field">
                                <textarea name="requirements[{{$key}}][answer]" @if(!empty($val['required'])) required @endif class="form-control" rows="3" placeholder="{{ __("Your answer...") }}"></textarea>
                            </div>
                        @else
                            <div class="answer">
                                {{ $val['answer'] ?? '' }}
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        @if($order->status == \Modules\Gig\Models\GigOrder::INCOMPLETE)
            <div class="text-center mt-4">
                <button type="submit" class="theme-btn btn-style-one bg-blue">{{ __("Submit Requirements") }}</button>
            </div>
        @endif
    </form>
</div>
