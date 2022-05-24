@if($category->faqs and !empty($category->faqs))
    @php $cat_translation = $category->translateOrOrigin(app()->getLocale()); @endphp
    <div class="category-faqs pb-5 pt-5 bg-fafafa">
        <div class="auto-container pb-5">
            <h2 class="category-page-title text-center mb-4">{{__(':name FAQs',['name'=>$cat_translation->name])}}</h2>
            <div class="category-faqs-accordion" id="accordionExample">
                @foreach($cat_translation->faqs as $k=>$faq)
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left d-flex align-items-center justify-content-between collapsed" type="button" data-toggle="collapse" data-target="#collapse{{$k}}" aria-expanded="true" aria-controls="collapseOne">
                                {{$faq['title'] ?? ''}}
                                <i class="las la-angle-up"></i>
                            </button>
                        </h2>
                    </div>

                    <div id="collapse{{$k}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                        <div class="card-body">
                            {!! nl2br(clean($faq['content'] ?? '')) !!}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endif
