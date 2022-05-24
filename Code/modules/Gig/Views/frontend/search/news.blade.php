<?php
if(empty($category->news_cat_id)) return;
$newsCat = \Modules\News\Models\NewsCategory::find($category->news_cat_id);
if(!$newsCat) return;
$news = \Modules\News\Models\News::search(['cat_id'=>$newsCat->id])->limit(3)->get();
if(!count($news)) return;

$cat_translation = $category->translateOrOrigin(app()->getLocale());

?>
<div class="category-news pt-5 pb-5">
    <div class="d-flex justify-content-between mb-4 align-items-center">
        <h2 class="category-page-title">{{__(':name Related Guides',['name'=>$cat_translation->name])}}</h2>
        <a href="{{$newsCat->getDetailUrl()}}">{{__('See more guides')}} <i class="las la-angle-right"></i></a>
    </div>
    <div class="blog-grid">
        <div class="row">
            @foreach($news as $row)
                <div class="news-block col-md-4">
                    @include('News::frontend.layouts.details.news-loop')
                </div>
            @endforeach
        </div>
    </div>

</div>
