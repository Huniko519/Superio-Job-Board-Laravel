<div class="bravo-faq-lists faqs-section p-0">
    <div class="auto-container">
        <h3 class="title">{{$title ?? ''}}</h3>
        @if(!empty($list_item))
            <ul class="accordion-box item-list">
            @foreach($list_item as $k => $item)
                <li class="accordion block {{ ($k == 0) ? 'active-block' : '' }}">
                    <div class="acc-btn {{ ($k == 0) ? 'active' : '' }}"> {{$item['title']}} <span class="icon flaticon-add"></span></div>
                    <div class="acc-content {{ ($k == 0) ? 'current' : '' }}">
                        <div class="content">
                            {!! clean($item['sub_title'],'html5-definitions') !!}
                        </div>
                    </div>
                </li>
            @endforeach
            </ul>
        @endif
    </div>
</div>
