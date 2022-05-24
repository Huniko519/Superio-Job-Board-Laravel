@if($category->children)
    @php
        $cat_translation = $category->translateOrOrigin(app()->getLocale());
    @endphp
    <div class="category-types pb-3 pt-2">
        <h2 class="category-page-title mb-4">{{__('Most popular in :name',['name'=>$cat_translation->name])}}</h2>
        <div class="row">
            @foreach($category->children as $cate)
                @php
                    $translation = $cate->translateOrOrigin(app()->getLocale());
                @endphp
                <div class="category-block col-lg-4 col-md-6 col-sm-12">
                    <div class="inner-box">
                        <a href="{{$cate->getDetailUrl()}}">
                        <div class="content">
                            @if($cate->image_id)
                                <div class="icon bg-cover div-70s" style="background-image: url('{{get_file_url($cate->image_id,'full')}}')"></div>
                            @endif
                            <h4>{{$translation->name}}</h4>
                        </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
