@php
    $translation = $row->translateOrOrigin(app()->getLocale());
@endphp
<div class="inner-box">
    <div class="image-box">
        <a href="{{$row->getDetailUrl()}}">
            <figure class="image">
                @if($row->image_id)
                    @if(!empty($disable_lazyload))
                        <img src="{{get_file_url($row->image_id,'medium')}}" alt="{{$translation->name ?? ''}}">
                    @else
                        {!! get_image_tag($row->image_id,'medium',['alt'=>$row->title]) !!}
                    @endif
                @endif
            </figure>
        </a>
    </div>
    <div class="lower-content">
        <ul class="post-meta">
            <li>{{ display_date($row->updated_at)}}</li>
            @if($row->getReviewEnable())
                <li><a href="{{ $row->getDetailUrl().'#reviews' }}">{{ $row->reviewsCount(true) }}</a></li>
            @endif
        </ul>
        <h3><a href="{{$row->getDetailUrl()}}">{{$translation->title}}</a></h3>
    </div>
</div>
