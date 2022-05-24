@if(request()->get('s'))
    <input type="hidden" name="s" value="{{ request()->get('s') }}">
@endif
@if(request()->get('date_posted'))
    <input type="hidden" name="date_posted" value="{{ request()->get('date_posted') }}">
@endif
@php
    $experience = request()->get('experience');
    $job_type = request()->get('job_type');
@endphp
@if(!empty($experience) && is_array($experience))
    @foreach($experience as $key => $val)
        <input type="hidden" name="experience[]" value="{{ $val }}">
    @endforeach
@endif
@if(!empty($job_type) && is_array($job_type))
    @foreach($job_type as $key => $val)
        <input type="hidden" name="job_type[]" value="{{ $val }}">
    @endforeach
@endif
@if(request()->get('category'))
    <input type="hidden" name="category" value="{{ request()->get('category') }}">
@endif
@if(request()->get('location'))
    <input type="hidden" name="location" value="{{ request()->get('location') }}">
@endif
@if(request()->get('amount_to'))
    <input type="hidden" name="amount_from" value="{{ request()->get('amount_from') ?? 0 }}">
    <input type="hidden" name="amount_to" value="{{ request()->get('amount_to') }}">
@endif
<select class="chosen-select" name="orderby" onchange="this.form.submit()">
    <option value="">{{__('Sort by (Default)')}}</option>
    <option value="new" @if(request()->get('orderby') == 'new') selected @endif>{{__('Newest')}}</option>
    <option value="old" @if(request()->get('orderby') == 'old') selected @endif>{{__('Oldest')}}</option>
    <option value="name_high" @if(request()->get('orderby') == 'name_high') selected @endif>{{__('Name [a->z]')}}</option>
    <option value="name_low" @if(request()->get('orderby') == 'name_low') selected @endif>{{__('Name [z->a]')}}</option>
</select>

<select class="chosen-select" name="limit" onchange="this.form.submit()">
    <option value="10" @if(request()->get('limit') == 10) selected @endif >{{ __("Show 10") }}</option>
    <option value="20" @if(request()->get('limit') == 20) selected @endif >{{ __("Show 20") }}</option>
    <option value="30" @if(request()->get('limit') == 30) selected @endif >{{ __("Show 30") }}</option>
    <option value="40" @if(request()->get('limit') == 40) selected @endif >{{ __("Show 40") }}</option>
    <option value="50" @if(request()->get('limit') == 50) selected @endif >{{ __("Show 50") }}</option>
    <option value="60" @if(request()->get('limit') == 60) selected @endif >{{ __("Show 60") }}</option>
</select>
@if(isset($_GET['_layout']))
    <input type="hidden" name="_layout" value="{{ $_GET['_layout'] }}">
@endif
