<section class="top-companies">
    <div class="auto-container">
        <div class="sec-title">
            <h2>{{ $title }}</h2>
            <div class="text">{{ $sub_title }}</div>
        </div>

        <div class="carousel-outer wow fadeInUp">
            <div class="companies-carousel owl-carousel owl-theme default-dots">
                @foreach($rows as $row)
                    @include('Company::frontend.blocks.list-company.loop',['btn_class' => 'btn-style-four'])
                @endforeach
            </div>
        </div>
    </div>
</section>
