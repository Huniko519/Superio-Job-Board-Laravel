<?php
if(!$category->children) return;
$translation = $category->translateOrOrigin(app()->getLocale());
?>
    <div class="category-faqs pt-5 pb-5">
        <h2 class="category-page-title text-center mb-5 mt-4">{{__('Services Related To :name',['name' => $translation->name])}}</h2>
        <div class="category-tag-lists mt-3 d-flex justify-content-center" id="accordionExample">
            @foreach($category->children as $cat)
                @php $cat_translation = $cat->translateOrOrigin(app()->getLocale()); @endphp
                <a class="cat-faq-item" href="{{$cat->getDetailUrl()}}">{{$cat_translation->name}}</a>
            @endforeach
        </div>
    </div>
