@extends('layouts.app')
@section('head')

@endsection
@section('content')
    <section class="tnc-section">
        <div class="auto-container">
            <div class="sec-title text-center">
                <h2>{{__("My Bookmarks")}}</h2>
            </div>
            <div class="blog-content">
                <div class="ls-widget">
                    <div class="tabs-box">
                        <div class="widget-content">
                            @include('admin.message')
                            @if($rows->total() > 0)
                                @foreach($rows as $row)
                                    <?php if(!$row->service) continue; ?>
                                    @switch($row->object_model)
                                        @case('candidate')
                                            <div class="candidate-block-three p-0">
                                            @include('Candidate::frontend.layouts.loop.item-v1',['row'=>$row->service])
                                            </div>
                                        @break
                                        @case('job')
                                            <div class="job-block">
                                            @include('Job::frontend.layouts.loop.job-item-1',['row'=>$row->service])
                                            </div>
                                        @break
                                        @case('company')
                                            @include('Company::frontend.layouts.search.companies-loop',['row'=>$row->service])
                                        @break
                                    @endswitch
                                @endforeach

                                <div class="bravo-pagination d-flex justify-content-between">
                                    <span class="count-string">{{ __("Showing :from - :to of :total",["from"=>$rows->firstItem(),"to"=>$rows->lastItem(),"total"=>$rows->total()]) }}</span>
                                    {{$rows->appends(request()->query())->links()}}
                                </div>
                            @else
                                {{__("No Items")}}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('footer')
@endsection
