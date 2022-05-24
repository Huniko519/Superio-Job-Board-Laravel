@php
    $translation = $row->translateOrOrigin(app()->getLocale());
@endphp
<div class="company-block-three">
    <div class="inner-box">
        <div class="content">
            <div class="content-inner">
                <span class="company-logo">
                    @if($image_tag = get_image_tag($row->avatar_id,'full',['alt'=>$translation->title, 'class'=>'img-fluid mb-4 rounded-xs w-100']))
                        {!! $image_tag !!}
                    @endif
                </span>
                <h4><a href="{{$row->getDetailUrl()}}">{!! clean($translation->name) !!}</a></h4>
                <ul class="job-info">
                    @if($row->location)
                        <li><span class="icon flaticon-map-locator"></span> {{ $row->location->name }}</li>
                    @endif
                    @php $category = $row->category; @endphp
                    @if(!empty($category))
                        @php $t = $category->translateOrOrigin(app()->getLocale()); @endphp
                        <li><span class="icon flaticon-briefcase"></span> {{$t->name ?? ''}}</li>
                    @endif
                </ul>
            </div>
            <ul class="job-other-info">
                @if($row->is_featured)
                    <li class="privacy">Featured</li>
                @endif
                <li class="time">{{ __("Open Jobs – :count",["count"=> number_format($row->job_count)]) }}</li>
            </ul>
        </div>
        <div class="text">{!! \Illuminate\Support\Str::words(strip_tags($translation->about), 30, '...') !!}</div>
        <button class="bookmark-btn @if($row->wishlist) active @endif service-wishlist" data-id="{{$row->id}}" data-type="{{$row->type}}"><span class="flaticon-bookmark"></span></button>
    </div>
</div>
