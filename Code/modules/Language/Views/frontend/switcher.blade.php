@php
    $languages = \Modules\Language\Models\Language::getActive();
    $locale = session('website_locale',app()->getLocale());
@endphp
@if(!empty($languages) && setting_item('site_enable_multi_lang'))
    <div class="position-relative px-3 u-header__login-form dropdown-connector-xl u-header__topbar-divider currency-select">
        <div class="d-flex align-items-center text-white py-3 dropdown">
            <span class="d-inline-block font-size-14 mr-1 dropdown-nav-link " data-toggle="dropdown">
                @foreach($languages as $language)
                    @if($locale == $language->locale)
                        @if($language->flag)
                            <span class="flag-icon flag-icon-{{$language->flag}}"></span>
                        @endif
                            {{$language->name}}
                    @endif
                @endforeach
            </span>
            <ul class="dropdown-menu dropdown-menu-user text-left width-auto">
                @foreach($languages as $language)
                    @if($locale != $language->locale)
                        <li>
                            <a href="{{get_lang_switcher_url($language->locale)}}" class="d-flex">
                                @if($language->flag)
                                    <span class="flag-icon flag-icon-{{$language->flag}} mr-2"></span>
                                @endif
                                {{$language->name}}
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
@endif
