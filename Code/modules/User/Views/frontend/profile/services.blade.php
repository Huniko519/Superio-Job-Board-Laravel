@php
    $services = Modules\Gig\Models\Gig::getVendorServicesQuery($user->id)->orderBy('id','desc')->paginate(6);
@endphp
@if(!empty($services) and $services->count() > 0)
    <div class="profile-service-tabs mb-4">
        <h3 class="profile-name">{{__(":name Gigs",['name'=>$user->getDisplayName()])}}</h3>
        <div class="list-service mt-4">
            @include('Gig::frontend.profile.service',['services'=>$services])
        </div>
    </div>
@endif
