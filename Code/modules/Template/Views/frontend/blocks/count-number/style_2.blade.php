@if(!empty($list_item))
<!-- Fun Fact Section -->
<div class="fun-fact-section">
    <div class="auto-container">
        <div class="row">
            @foreach($list_item as $key => $val)
            <!--Column-->
            <div class="counter-column col-lg-4 col-md-4 col-sm-12 wow fadeInUp">
                <div class="count-box"><span class="count-text" data-speed="3000" data-stop="{{ $val['number'] ?? '' }}">0</span>{{ $val['symbol'] ?? '' }}</div>
                <h4 class="counter-title">{{ $val['desc'] ?? '' }}</h4>
            </div>
            @endforeach
        </div>
    </div>
</div>
<!-- Fun Fact Section -->
@endif
