@php
    $actives = \App\Currency::getActiveCurrency();
    $current = \App\Currency::getCurrent('currency_main');
@endphp
@if(!empty($actives) and count($actives) > 1)
    <div class="position-relative px-3 u-header__login-form dropdown-connector-xl u-header__topbar-divider currency-select">
        <div class="d-flex align-items-center text-white py-3 dropdown">
            <span class="d-inline-block font-size-14 mr-1 dropdown-nav-link " data-toggle="dropdown">
                @foreach($actives as $currency)
                    @if($current == $currency['currency_main'])
                        {{strtoupper($currency['currency_main'])}}
                    @endif
                @endforeach
            </span>
            <ul class="dropdown-menu text-left width-auto min-width-100">
                @foreach($actives as $currency)
                    @if($current != $currency['currency_main'])
                        <li>
                            <a href="{{get_currency_switcher_url($currency['currency_main'])}}">
                                {{strtoupper($currency['currency_main'])}}
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
@endif