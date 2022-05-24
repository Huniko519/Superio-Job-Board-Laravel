
<section class="candidates-section">
    <div class="auto-container">
        <div class="sec-title-outer">
            <div class="sec-title">
                <h2>{{$title}}</h2>
                <div class="text">{{$desc}}</div>
            </div>
            @if(!empty($load_more_url))
                <a href="{{ $load_more_url }}" class="link">{{ $load_more_name }}<span class="fa fa-angle-right"></span></a>
            @endif
        </div>
        <div class="carousel-outer wow fadeInUp">
            <div class="candidates-carousel owl-carousel owl-theme default-dots">
                <!-- Candidate Block -->
                @foreach($rows as $row)
                    @include('Candidate::frontend.blocks.list-candidates.loop')
                @endforeach
            </div>
        </div>
    </div>
</section>
<!-- End Candidates Section -->
