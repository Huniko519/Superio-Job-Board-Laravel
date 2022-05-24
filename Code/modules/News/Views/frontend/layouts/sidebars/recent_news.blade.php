<div class="sidebar-widget widget_bloglist recent-post">
    <div class="sidebar-title">
        <h4>{{ $item->title }}</h4>
    </div>
    <div class="widget-content thumb-list">
        @php $list_blog = $model_news->with(['getCategory','translations'])->orderBy('id','desc')->paginate(5) @endphp
        @if($list_blog)
            @foreach($list_blog as $blog)
                @php $translation = $blog->translateOrOrigin(app()->getLocale()) @endphp
                <article class="post">
                    @if($image_url = get_file_url($blog->image_id, 'thumb'))
                        <div class="post-thumb">
                            <a href="{{ $blog->getDetailUrl(app()->getLocale()) }}">{!! get_image_tag($blog->image_id,'thumb',['class'=>'','alt'=>$blog->title]) !!}</a>
                        </div>
                    @endif
                    <h6>
                        <a href="{{ $blog->getDetailUrl(app()->getLocale()) }}">{{$translation->title}}</a>
                    </h6>
                    <div class="post-info">
                        {{ display_date($blog->updated_at)}}
                    </div>
                </article>
            @endforeach
        @endif
    </div>
</div>
