@if(!empty($model_tag))
<div class="sidebar-widget widget_tag_cloud">
    <div class="sidebar-title"><h4>{{ $item->title }}</h4></div>
    <ul class="tag-list">
        @php
            $list_tags = \Modules\News\Models\NewsTag::getTags();
        @endphp
        @if($list_tags)
            @foreach($list_tags as $tag)
                @php $translation = $tag->translateOrOrigin(app()->getLocale()) @endphp
                <li>
                    <a href="{{ $tag->getDetailUrl(app()->getLocale()) }}" class="tag-cloud-link">{{$translation->name}}</a>
                </li>
            @endforeach
        @endif
    </ul>
</div>
@endif
