@if($category->types)
    @php
        $cat_translation = $category->translateOrOrigin(app()->getLocale());
    @endphp
    <div class="category-types">
        <h2 class="category-page-title mb-4">{{__('Explore :name',['name' => $cat_translation->name])}}</h2>
        <div class="row">
            @foreach($category->types as $category_type)
                @php
                    $type_translation = $category_type->translateOrOrigin(app()->getLocale());
                @endphp
                <div class="col-md-4 mb-5">
                    <div class="c-type-item h-100">
                        @if($category_type->image_id)
                            <div class="bg-cover div-16-9 border-radius-8 mb-3" style="background-image: url('{{get_file_url($category_type->image_id,'full')}}')"></div>
                        @endif
                        <h3 class="c-type-name fw-500 fs-18 mb-3">{{$type_translation->name}}</h3>
                        <ul class="list-unstyled c-type-children">
                            @foreach($category_type->children() as $child_cat)
                                @php
                                    $child_cat_translation = $child_cat->translateOrOrigin(app()->getLocale());
                                @endphp
                                <li class="mb-2"><a class="d-block c-62646a" href="{{$child_cat->getDetailUrl()}}">{{$child_cat_translation->name}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
