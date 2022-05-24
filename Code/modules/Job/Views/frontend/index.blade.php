@extends('layouts.app')

@section('content')
    @includeIf('Job::frontend.layouts.search.'. $style)
@endsection

@section('footer')
    @if($style == 'job-list-v8' || $style == 'job-list-v9')
        {!! App\Helpers\MapEngine::scripts() !!}
    @endif
    <script>
        jQuery(".view-more").on("click", function () {
            jQuery(this).closest('ul').find('li.tg').toggleClass("d-none");
            jQuery(this).find('.tg-text').toggleClass('d-none');
        });

        if($( ".job-salary-range-slider" ).length) {
            //Salary Range Slider
            $(".job-salary-range-slider").slider({
                range: true,
                min: {{ $min_max_price[0] }},
                max: {{ $min_max_price[1] }},
                values: [ {{ request()->get('amount_from') ?? 0 }}, {{ request()->get('amount_to') ?? $min_max_price[1] }} ],
                slide: function (event, ui) {
                    $(".job-salary-amount .min").text(bc_format_money(ui.values[0]));
                    $(".job-salary-amount .max").text(bc_format_money(ui.values[1]));
                    $("input[name=amount_from]").val(ui.values[0]);
                    $("input[name=amount_to]").val(ui.values[1]);
                }
            });

            $(".job-salary-amount .min").text(bc_format_money($(".job-salary-range-slider").slider("values", 0)));
            $(".job-salary-amount .max").text(bc_format_money($(".job-salary-range-slider").slider("values", 1)));
        }
        if($("#bc_results_map").length) {
            var bravo_map_data = {
                markers: {!! json_encode($markers) !!},
                center: [{{ !empty($markers[0]['lat']) ? $markers[0]['lat'] : 40.80 }}, {{ !empty($markers[0]['lng']) ? $markers[0]['lng'] : -73.70 }}]
            };
            var mapEngine = new BravoMapEngine('bc_results_map', {
                fitBounds: true,
                center: bravo_map_data.center,
                zoom: 9,
                disableScripts: true,
                ready: function (engineMap) {
                    if (bravo_map_data.markers) {
                        engineMap.addMarker3(bravo_map_data.markers);
                    }
                }
            });
        }
    </script>
@endsection
