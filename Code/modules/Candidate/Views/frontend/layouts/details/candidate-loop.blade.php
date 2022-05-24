@php $translation = $row->translateOrOrigin(app()->getLocale()); @endphp
<div class="mb-4">
    @if($image_tag = get_image_tag($row->image_id,'full',['alt'=>$translation->title,'class'=>'img-fluid mb-4 rounded-xs w-100']))
        <a class="d-block" href="{{$row->getDetailUrl()}}">
            {!! $image_tag !!}
        </a>
    @endif
    <h5 class="font-weight-bold font-size-21 text-gray-3">
        <a href="{{$row->getDetailUrl()}}">{{$translation->title}}</a>
    </h5>
    <div class="mb-3">
        <a class="mr-3 pr-1" href="#">
            <span class="font-weight-normal text-gray-3">{{ display_date($row->updated_at)}}</span>
        </a>
        @php $category = $row->getCategory(); @endphp
    </div>
    <p class="mb-0 text-lh-lg">
        {!! get_exceprt($translation->content,300,'...') !!}
    </p>
</div>
