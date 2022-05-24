@if($row->getGallery())
    <div class="portfolio-outer">
        <h4 class="mb-5">{{__('Photos')}}</h4>
        <div class="row">
            @foreach($row->getGallery() as $key=>$item)
                @if(!empty($item['thumb']))
                    <div class="col-lg-3 col-md-3 col-sm-6 col-6">
                        <figure class="image">
                            <a href="{{$item['large']}}" class="lightbox-image"><img src="{{$item['thumb']}}" alt="gallery"></a>
                            <span class="icon flaticon-plus"></span>
                        </figure>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endif
