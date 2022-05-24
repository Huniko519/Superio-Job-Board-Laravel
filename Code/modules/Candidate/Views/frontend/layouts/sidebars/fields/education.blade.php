<!-- Checkboxes Ouer -->
<div class="checkbox-outer">
    <h4>{{ $val['title'] }}</h4>
    <ul class="checkboxes square">
        <li>
            <input id="check-edu0" type="checkbox" name="education_level[]" value="certificate" @if(!empty($experience = request()->get('education_level')) && in_array('certificate', $experience)) checked @endif>
            <label for="check-edu0">{{ __("Certificate") }}</label>
        </li>
        <li>
            <input id="check-edu1" type="checkbox" name="education_level[]" value="diploma" @if(!empty($experience = request()->get('education_level')) && in_array('diploma', $experience)) checked @endif>
            <label for="check-edu1">{{ __("Diploma") }}</label>
        </li>
        <li>
            <input id="check-edu2" type="checkbox" name="education_level[]" value="associate" @if(!empty($experience = request()->get('education_level')) && in_array('associate', $experience)) checked @endif>
            <label for="check-edu2">{{ __("Associate Degree") }}</label>
        </li>
        <li>
            <input id="check-edu3" type="checkbox" name="education_level[]" value="bachelor" @if(!empty($experience = request()->get('education_level')) && in_array('bachelor', $experience)) checked @endif>
            <label for="check-edu3">{{ __("Bachelor Degree") }}</label>
        </li>
        <li>
            <input id="check-edu4" type="checkbox" name="education_level[]" value="master" @if(!empty($experience = request()->get('education_level')) && in_array('master', $experience)) checked @endif>
            <label for="check-edu4">{{ __("Master’s Degree") }}</label>
        </li>
        <li class="tg d-none">
            <input id="check-edu5" type="checkbox" name="education_level[]" value="professional" @if(!empty($experience = request()->get('education_level')) && in_array('professional', $experience)) checked @endif>
            <label for="check-edu5">{{ __("Professional’s Degree") }}</label>
        </li>
        <li>
            <button class="view-more" type="button"><span class="icon flaticon-plus"></span>
                <span class="tg-text">{{ __("View More") }}</span>
                <span class="tg-text d-none">{{ __("Show Less") }}</span>
            </button>
        </li>
    </ul>
</div>
