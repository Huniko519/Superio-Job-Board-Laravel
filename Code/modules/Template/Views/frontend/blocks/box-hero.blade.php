<section class="page-title {{ (!empty($bg_class)) ? $bg_class : '' }}" style="background-color: {{ $bg_color ?? '' }}">
    <div class="auto-container">
        <div class="title-outer">
            <h1>{{ $title }}</h1>
            <ul class="page-breadcrumb">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li>{{ $sub_title }}</li>
            </ul>
        </div>
    </div>
</section>
