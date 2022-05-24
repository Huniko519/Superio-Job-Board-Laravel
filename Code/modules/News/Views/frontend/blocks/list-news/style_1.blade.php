<!-- News Section -->
<section class="news-section">
    <div class="auto-container">
        <div class="sec-title text-center">
            <h2>{{ $title }}</h2>
            @if(!empty($sub_title))
                <div class="text">{{ $sub_title }}</div>
            @endif
        </div>

        <div class="row wow fadeInUp">
        @foreach($rows as $row)
            <!-- News Block -->
                <div class="news-block col-lg-4 col-md-6 col-sm-12">
                    @include('News::frontend.blocks.list-news.loop')
                </div>
            @endforeach
        </div>
    </div>
</section>
<!-- End News Section -->
