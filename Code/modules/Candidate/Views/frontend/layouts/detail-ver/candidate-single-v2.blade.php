<div class="bravo-candidates">
@php
    $title_page = (!empty($custom_title_page)) ? $custom_title_page : setting_item_with_lang("candidate_page_list_title");
    $translation = $row->translateOrOrigin(app()->getLocale());
@endphp
    <section class="candidate-detail-section style-two">
        <div class="candidate-detail-outer">
            <div class="auto-container">
                <div class="row">
                    <div class="content-column col-lg-8 col-md-12 col-sm-12">
                        <div class="candidate-block-five">
                            <div class="inner-box">
                                @include('Candidate::frontend.layouts.details.candidate-block')
                            </div>
                        </div>
                        @include('Candidate::frontend.layouts.details.candidate-detail')
                    </div>
                    <div class="sidebar-column col-lg-4 col-md-12 col-sm-12">
                        <div class="sidebar">
                            @include('Candidate::frontend.layouts.details.candidate-btn-box')
                            @include('Candidate::frontend.layouts.details.candidate-sidebar')
                        </div>
                    </div>
                </div>
            </div>
            {{--<!-- Upper Box -->
            @include('Candidate::frontend.layouts.details.candidate-header')
            <div class="candidate-detail-outer">
                <div class="auto-container">
                    <div class="row">
                        @include('Candidate::frontend.layouts.details.candidate-detail')

                        @include('Candidate::frontend.layouts.details.candidate-sidebar')
                    </div>
                </div>
            </div>--}}
        </div>
    </section>
</div>
