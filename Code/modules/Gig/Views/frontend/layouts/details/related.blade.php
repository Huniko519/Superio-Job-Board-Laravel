@if(!empty($gig_related) && count($gig_related) > 0)
    <div class="related-jobs">
        <div class="title-box">
            <h3>{{ __("Recommended For You") }}</h3>
        </div>
        <div class="row">
            @foreach($gig_related as $row)
                <div class="col-md-4">
                    @include("Gig::frontend.search.loop")
                </div>
            @endforeach
        </div>
    </div>
@endif
