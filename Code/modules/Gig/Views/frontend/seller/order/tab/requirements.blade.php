@php
$requirements = $order->requirements;
@endphp
<div class="bc-order-panel requirements-tab">
    <div class="bc-list-requirements">
        @foreach($requirements as $key => $val)
            <div class="requirement-item">
                <span class="index">{{ $key + 1 }}</span>
                <div class="r-right">
                    <h4 class="question">{{ $val['content'] ?? '' }}</h4>
                    <div class="answer">
                        {{ $val['answer'] ?? '' }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
