@if($faqs = $translation->faqs and  !empty($faqs[0]['title']))
    <h4 class="title mb-4"> {{__("FAQs")}}</h4>
    <ul class="accordion-box">
        @foreach($faqs as $key=>$item)
            <li class="accordion block @if($key == 0 ) active-block @endif">
                <div class="acc-btn @if($key == 0 ) active @endif ">{{$item['title']}} <span class="icon flaticon-add"></span></div>
                <div class="acc-content @if($key == 0 ) current @endif ">
                    <div class="content">
                        <p>{!! clean($item['content']) !!}</p>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
@endif