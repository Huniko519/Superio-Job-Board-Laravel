<div class="sidebar-widget widget_search search-box">
    <div class="sidebar-title">
        <h4>{{ __('Search by Keywords') }}</h4>
    </div>

    <form action="{{ url(app_get_locale(false,false,'/').config('news.news_route_prefix')) }}">
        <div class="form-group">
            <span class="icon flaticon-search-1"></span>
            <input type="search" name="s" value="{{ Request::query("s") }}" placeholder="{{__("keywords ...")}}" aria-label="{{ __("Company or title") }}">
        </div>
    </form>
</div>
