@if ($paginator->hasPages())
    <nav aria-label="{{__('Page navigation')}}">
        <ul class="list-pagination-1 pagination border border-color-4 rounded-sm overflow-auto overflow-xl-visible justify-content-md-center align-items-center py-2 mb-0">
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <a class="page-link border-right rounded-0 text-gray-5" href="javascript:void(0)" aria-label="{{__("Previous")}}">
                        <i class="flaticon-left-direction-arrow font-size-10 font-weight-bold"></i>
                        <span class="sr-only">{{__("Previous")}}</span>
                    </a>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link border-right rounded-0 text-gray-5" href="{{ $paginator->previousPageUrl() }}" aria-label="{{__("Previous")}}">
                        <i class="flaticon-left-direction-arrow font-size-10 font-weight-bold"></i>
                        <span class="sr-only">{{__("Previous")}}</span>
                    </a>
                </li>
            @endif
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span>{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page"><span class="page-link font-size-14">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link font-size-14" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link border-left rounded-0 text-gray-5" href="{{ $paginator->nextPageUrl() }}" aria-label="{{__("Next")}}">
                        <i class="flaticon-right-thin-chevron font-size-10 font-weight-bold"></i>
                        <span class="sr-only">{{__("Next")}}</span>
                    </a>
                </li>
            @else
                <li class="page-item disabled">
                    <a class="page-link border-left rounded-0 text-gray-5" href="javascript:void(0)" aria-label="{{__("Next")}}">
                        <i class="flaticon-right-thin-chevron font-size-10 font-weight-bold"></i>
                        <span class="sr-only">{{__("Next")}}</span>
                    </a>
                </li>
            @endif
        </ul>
    </nav>

@endif
