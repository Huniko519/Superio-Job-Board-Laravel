@if(!empty($breadcrumbs))
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-no-gutter mb-0 flex-nowrap flex-xl-wrap overflow-auto overflow-xl-visble">
            <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="{{url('')}}">{{__('Home')}}</a></li>
            @foreach($breadcrumbs as $breadcrumb)
                <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 {{$breadcrumb['class'] ?? ''}}">
                    @if(!empty($breadcrumb['url']))
                        <a href="{{url($breadcrumb['url'])}}">{{$breadcrumb['name']}}</a>
                    @else
                        {{$breadcrumb['name']}}
                    @endif
                </li>
            @endforeach
        </ol>
    </nav>
@endif