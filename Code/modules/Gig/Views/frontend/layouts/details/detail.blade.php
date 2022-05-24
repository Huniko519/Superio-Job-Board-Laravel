<div class="job-block-outer">
    <div class="job-block-seven">
        <div class="inner-box">
            <div>
                <h4>{!! clean($translation->title) !!}</h4>
                <ul class="job-info">
                    @if($row->cat)
                        @php $cat_translation = $row->cat->translateOrOrigin(app()->getLocale()); @endphp
                        <li><span class="icon flaticon-briefcase"></span> {{ $cat_translation->name }}</li>
                    @endif
                    @if($row->cat2)
                        @php $cat_translation = $row->cat2->translateOrOrigin(app()->getLocale()); @endphp
                        <li><span class="icon flaticon-briefcase"></span> {{ $cat_translation->name }}</li>
                    @endif
                    @if($row->cat3)
                        @php $cat_translation = $row->cat3->translateOrOrigin(app()->getLocale()); @endphp
                        <li><span class="icon flaticon-briefcase"></span> {{ $cat_translation->name }}</li>
                    @endif
                </ul>
                <?php
                $reviewData = $row->getScoreReview();
                $score_total = $reviewData['score_total'];
                ?>
                <div class="service-review review-{{$score_total}}">
                    <div class="d-inline-flex align-items-center">
                        <div class="list-star">
                            <ul class="item-rating-stars">
                                <li><i class="far fa-star"></i></li>
                                <li><i class="far fa-star"></i></li>
                                <li><i class="far fa-star"></i></li>
                                <li><i class="far fa-star"></i></li>
                                <li><i class="far fa-star"></i></li>
                            </ul>
                            <div class="item-rating-stars-active" style="width: {{  $score_total * 2 * 10 ?? 0  }}%">
                                <ul class="item-rating-stars">
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                </ul>
                            </div>
                        </div>
                        <span class="text-secondary">
                            @if($reviewData['total_review'] > 1)
                                {{ __(":number Reviews",["number"=>$reviewData['total_review'] ]) }}
                            @else
                                {{ __(":number Review",["number"=>$reviewData['total_review'] ]) }}
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@if($row->getGallery())
    <div class="g-gallery">
        <div class="fotorama" data-width="100%" data-thumbwidth="90" data-thumbheight="90" data-thumbmargin="15" data-nav="thumbs" data-allowfullscreen="true">
            @foreach($row->getGallery() as $key=>$item)
                <a href="{{$item['large']}}" data-thumb="{{$item['thumb']}}" data-alt="{{ __("Gallery") }}"></a>
            @endforeach
        </div>
    </div>
@endif
<div class="overview mb-4">
    <h4 class="mb-4">{{ __("About This Gig") }}</h4>
    <p>
        <?php echo $translation->content ?>
    </p>
</div>

@include('Gig::frontend.layouts.details.profile-card')

@include('Gig::frontend.layouts.details.compare-packages')

@if(!empty($row->video_url))
    <div class="video-outer">
        <h4>{{ __("Gig Video") }}</h4>
        <div class="video-box">
            <figure class="image">
                <a href="{{$row->video_url}}" class="play-now" data-fancybox="gallery" data-caption="">
                    {!! get_image_tag($row->image_id,'full',['alt'=>$row->title]) !!}
                    <i class="icon flaticon-play-button-3" aria-hidden="true"></i>
                </a>
            </figure>
        </div>
    </div>
@endif

@include('Gig::frontend.layouts.details.faqs')

<div class="other-options">
    <div class="social-share">
        <h5>{{ __("Share this job") }}</h5>
        <a href="https://www.facebook.com/sharer/sharer.php?u={{ $row->getDetailUrl() }}&amp;title={{ $translation->title }}" target="_blank" class="facebook"><i class="fab fa-facebook-f"></i> {{ __("Facebook") }}</a>
        <a href="https://twitter.com/share?url={{ $row->getDetailUrl() }}&amp;title={{ $translation->title }}" target="_blank" class="twitter"><i class="fab fa-twitter"></i> {{ __("Twitter") }}</a>
        <a href="http://pinterest.com/pin/create/button/?url={{ $row->getDetailUrl() }}&description={{ $translation->title }}" target="_blank" class="google"><i class="fab fa-pinterest"></i> {{ __("Pinterest") }}</a>
    </div>
</div>
@include('Review::frontend.form')
@include('Gig::frontend.layouts.details.related')
