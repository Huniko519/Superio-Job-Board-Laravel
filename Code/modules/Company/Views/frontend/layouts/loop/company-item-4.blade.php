@php
    $translation = $row->translateOrOrigin(app()->getLocale());
@endphp
<div class="company-block-three col-xl-6 col-lg-12 col-md-12 col-sm-12">
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
                        @php $location_translation = $row->location->translateOrOrigin(app()->getLocale()); @endphp
                        <li><span class="icon flaticon-map-locator"></span> {{ $location_translation->name }}</li>
                    @endif
                        @php $category = $row->category; @endphp
                        @if(!empty($category))
                            @php $t = $category->translateOrOrigin(app()->getLocale()); @endphp
                            <li><span class="icon flaticon-briefcase"></span> {{$t->name ?? ''}}</li>
                        @endif
                </ul>
            </div>
            <ul class="job-other-info">
                @if($row->job_count > 0)
                    <li class="time">{{ __("Open Jobs – :count",["count"=> number_format($row->job_count)]) }}</li>
                @endif
            </ul>
        </div>
        <button class="bookmark-btn @if($row->wishlist) active @endif service-wishlist" data-id="{{$row->id}}" data-type="{{$row->type}}"><span class="flaticon-bookmark"></span></button>
    </div>
</div>
