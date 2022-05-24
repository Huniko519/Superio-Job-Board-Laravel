<section class="features-section">
    <div class="auto-container">
        <div class="sec-title-outer">
            <div class="sec-title">
                <h2>{{ $title }}</h2>
                <div class="text">{{ $sub_title }}</div>
            </div>
            @if(!empty($load_more_url))
                <a href="{{ $load_more_url }}" class="link">{{ $load_more_name }}<span class="fa fa-angle-right"></span></a>
            @endif
        </div>
        <div class="row wow fadeInUp">
            @if(!empty($rows))
                @foreach($rows as $key => $row)
                    @if($key == 0)
                        <div class="column col-lg-4 col-md-6 col-sm-12">
                            @include("Location::frontend.blocks.list-locations.loop")
                        </div>
                    @else
                        @if($key == 1 || $key == 3 || $key > 4)
                            <div class="column col-lg-4 col-md-6 col-sm-12">
                        @endif
                            @include("Location::frontend.blocks.list-locations.loop")
                        @if($key == 2 || $key == 4 || (count($rows) == 2 && $key == 1) || (count($rows) == 4 && $key == 3) || $key > 4)
                            </div>
                        @endif
                    @endif
                @endforeach
            @endif
        </div>
    </div>
</section>
