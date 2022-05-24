@php
    $translation = $row->translateOrOrigin(app()->getLocale());
@endphp
<div class="company-block">
    <div class="inner-box">
        <figure class="image">
            @if($image_tag = get_image_tag($row->avatar_id,'full',['alt'=>$translation->title]))
                {!! $image_tag !!}
            @endif
        </figure>
        <h4 class="name">{{ $translation->name }}</h4>
        @if($row->location)
            <div class="location"><i class="flaticon-map-locator"></i> {{ $row->location->name }}</div>
        @endif
        <a href="{{$row->getDetailUrl()}}" class="theme-btn {{ $btn_class ?? 'btn-style-three' }}">{{ __(":count Open Position",["count"=> number_format($row->job_count)]) }}</a>
    </div>
</div>
