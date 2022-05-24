<div class="job-overview-two">
    <h4>{{ __("Job Overview") }}</h4>
    <ul>
        @if($row->created_at)
            <li>
                <i class="icon icon-calendar"></i>
                <h5>{{ __("Date Posted:") }}</h5>
                <span>{{ __("Posted :time_ago", ['time_ago' => $row->timeAgo()]) }}</span>
            </li>
        @endif
        @if($row->expiration_date)
            <li>
                <i class="icon icon-expiry"></i>
                <h5>{{ __("Expiration date:") }}</h5>
                <span>{{ display_date($row->expiration_date) }}</span>
            </li>
        @endif
        @if($row->location)
            @php $location_translation = $row->location->translateOrOrigin(app()->getLocale()) @endphp
            <li>
                <i class="icon icon-location"></i>
                <h5>{{ __("Location:") }}</h5>
                <span>{{ $location_translation->name }}</span>
            </li>
        @endif
        @if($row->hours)
            <li>
                <i class="icon icon-clock"></i>
                <h5>{{ __("Hours:") }}</h5>
                <span>{{ $row->hours }} @if($row->hours_type)/ {{ $row->hours_type }} @endif</span>
            </li>
        @endif
        @if($row->salary_min && $row->salary_max)
            <li>
                <i class="icon icon-salary"></i>
                <h5>{{ __("Salary:") }}</h5>
                <span>{{ $row->getSalary() }}</span>
            </li>
        @endif
        <li>
            <span class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" version="1.1" width="22" height="22" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                <g>
                <g xmlns="http://www.w3.org/2000/svg">
                    <g>
                        <g>
                            <path d="M510.702,438.722c-2.251-10.813-12.844-17.753-23.656-15.503c-10.815,2.252-17.756,12.843-15.504,23.657     c1.297,6.228-0.247,12.613-4.236,17.518c-2.311,2.84-7.461,7.606-15.999,7.606H361c-11.046,0-20,8.954-20,20     c0,11.046,8.954,20,20,20h90.307c18.329,0,35.471-8.153,47.032-22.369C509.957,475.344,514.464,456.789,510.702,438.722z" fill="#1967d2" data-original="#000000" style="" class=""/>
                            <path d="M276.306,272.769c65.707,6.052,125.477,41.269,162.703,96.788c6.15,9.174,18.576,11.626,27.749,5.474     c9.175-6.152,11.625-18.576,5.474-27.75c-32.818-48.946-80.475-84.53-134.812-102.412C370.535,220.04,392,180.48,392,136     C392,61.009,330.99,0,256,0S120,61.009,120,136c0,44.509,21.492,84.092,54.643,108.917     c-30.371,9.998-58.871,25.547-83.813,46.062c-45.732,37.617-77.529,90.087-89.532,147.743     c-3.762,18.067,0.745,36.622,12.363,50.909C25.221,503.847,42.364,512,60.693,512H148c11.046,0,20-8.954,20-20     c0-11.046-8.954-20-20-20H60.691c-8.538,0-13.688-4.765-15.999-7.606c-3.989-4.906-5.533-11.29-4.236-17.519     c19.584-94.068,98.98-164.202,193.187-173.885l-38.181,173.709c-1.463,6.663,0.569,13.612,5.392,18.435l40.002,40.007     c3.75,3.752,8.838,5.859,14.144,5.859c5.305,0,10.392-2.108,14.143-5.859l39.998-40.007c4.823-4.824,6.855-11.772,5.391-18.434     L276.306,272.769z M160,136c0-52.935,43.065-96,96-96s96,43.065,96,96c0,51.337-40.505,93.389-91.235,95.882     c-1.586-0.029-3.174-0.048-4.765-0.048c-1.561,0-3.12,0.023-4.679,0.051C200.551,229.436,160,187.366,160,136z M254.999,462.713     l-18.117-18.12l18.117-82.425l18.115,82.426L254.999,462.713z" fill="#1967d2" data-original="#000000" style="" class=""/>
                        </g>
                    </g>
                </g>
                </g>
            </svg>
            </span>
            <h5>{{ __("Experience:") }}</h5>
            <span>
                @if(empty($row->experience) || (float)$row->experience < 1)
                    {{ __("Fresh") }}
                @else
                    {{ $row->experience }} {{ $row->experience > 1 ? __("years") : __("year") }}
                @endif
            </span>
        </li>
        @if($row->gender)
            <li>
                <i class="icon icon-user-2"></i>
                <h5>{{ __("Gender:") }}</h5>
                <span>{{ $row->gender  }}</span>
            </li>
        @endif
    </ul>
</div>
