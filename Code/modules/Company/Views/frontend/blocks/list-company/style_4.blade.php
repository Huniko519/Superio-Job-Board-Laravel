<section class="top-companies">
    <div class="auto-container">
        <div class="sec-title">
            <h2>{{ $title }}</h2>
            <div class="text">{{ $sub_title }}</div>
        </div>

        <div class="carousel-outer wow fadeInUp">
            <div class="companies-carousel-two owl-carousel owl-theme default-dots">
                @foreach($rows as $row)
                    @php
                        $translation = $row->translateOrOrigin(app()->getLocale());
                    @endphp
                    <div class="company-block">
                        <div class="inner-box bg-clr-1">
                            <figure class="image">
                                @if($image_tag = get_image_tag($row->avatar_id,'full',['alt'=>$translation->title]))
                                    {!! $image_tag !!}
                                @endif
                            </figure>
                            <h4 class="name">{{ $translation->name }}</h4>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
