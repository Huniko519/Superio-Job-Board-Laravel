@extends ('layouts.app')
@section ('content')
    @if($row->template_id)
        <div class="page-template-content page-{{$row->slug}}">
            {!! $row->getProcessedContent() !!}
        </div>
    @else
        <section class="tnc-section">
            <div class="auto-container">
                <div class="sec-title text-center">
                    <h2>{{$translation->title}}</h2>
                    <div class="text"><a href="{{ home_url() }}">{{ __("Home") }}</a> / {{$translation->title}}</div>
                </div>
                <div class="blog-content">
                    {!! $translation->content !!}
                </div>
            </div>
        </section>
    @endif
@endsection
