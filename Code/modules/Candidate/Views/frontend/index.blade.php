
@extends('layouts.app')

@section('content')
    @include('Candidate::frontend.layouts.search.'. $style)
@endsection

@section('footer')
    <script>
        jQuery(".view-more").on("click", function () {
            jQuery(this).closest('ul').find('li.tg').toggleClass("d-none");
            jQuery(this).find('.tg-text').toggleClass('d-none');
        });
    </script>
@endsection
