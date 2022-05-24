@if($category->children)
    <div class="category-children">
        <div class="row ">
            @foreach($category->children as $cate)
                @php $cat_translation = $cate->translateOrOrigin(app()->getLocale()); @endphp
                <div class="category-block-three col-lg-2 col-md-3 col-sm-6">
                    <div class="inner-box h-100">
                        <a href="{{$cate->getDetailUrl()}}">
                            <div class="content">
                                @if($cate->image_id)
                                    <div class="icon bg-cover div-70s" style="background-image: url('{{get_file_url($cate->image_id,'full')}}')"></div>
                                @endif
                                <h4>{{$cat_translation->name}}</h4>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
    </div>
    </div>
@endif
