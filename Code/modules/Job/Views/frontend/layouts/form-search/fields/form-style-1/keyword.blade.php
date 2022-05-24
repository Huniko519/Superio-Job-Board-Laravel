<!-- Filter Block -->
<div class="filter-block">
    <h4>{{ $val['title'] }}</h4>
    <div class="form-group">
        <input type="text" name="s" value="{{ request()->input('s') }}" placeholder="{{ __("Job title...") }}">
        <span class="icon flaticon-search-3"></span>
    </div>
</div>
