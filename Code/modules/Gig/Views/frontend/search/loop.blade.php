@php $translation = $row->translateOrOrigin(app()->getLocale()); @endphp
<div class="gig-item h-100 border-radius-8">
    <div class="d-flex flex-column h-100">
        <a href="{{$row->getDetailUrl()}}" class="gig-img">
            @if($row->image_id)
                {!! get_image_tag($row->image_id,'full',['alt'=>$row->title]) !!}
            @else
                {{ __("GIG") }}
            @endif
        </a>
        <div class="gig-content flex-grow-1">
            <div class="gig-author mb-3 d-flex align-items-center">
                @if(!empty($author = $row->author))
                    <div class="gig-author-img mr-2">
                        <img src="{{$author->avatar_url}}" alt="{{$author->display_name}}">
                    </div>
                    <div class="author-name"><a class="c-222325" href="{{$author->getDetailUrl()}}">{{$author->display_name}}</a></div>
                @endif
            </div>
            <h3 class="g-title fs-16 fs-16"><a href="{{$row->getDetailUrl()}}">{{$translation->title}}</a></h3>
        </div>
        <div class="gig-footer p3 d-flex justify-content-between flex-shrink-0">
            <div class="div">

                <?php
                $reviewData = $row->getScoreReview();
                $score_total = $reviewData['score_total'];
                ?>
                @if($reviewData['total_review'] > 1)
                <div class="rating d-inline-block">
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <div class="rating-active" style="width: {{  $score_total * 2 * 10 ?? 0  }}%">
                        <div class="inner">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </div>
                    </div>
                </div>
                ({{$reviewData['total_review']}})
                @endif
            </div>
            <div>
                <span class="c-7a7d85">{{__("Starting at ")}}</span>
                 <span class="fs-20">{{format_money($row->basic_price)}}</span>
            </div>
        </div>
    </div>
</div>
