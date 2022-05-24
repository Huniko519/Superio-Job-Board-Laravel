<div class="bravo-candidates">
@php
    $title_page = setting_item_with_lang("candidate_page_list_title");
    if(!empty($custom_title_page)){
        $title_page = $custom_title_page;
    }
    $translation = $row->translateOrOrigin(app()->getLocale());
@endphp

<!-- Candidate Detail Section -->
    <section class="candidate-detail-section">
        <!-- Upper Box -->
        @include('Candidate::frontend.layouts.details.candidate-header')
        <div class="candidate-detail-outer">
            <div class="auto-container">
                <div class="row">
                    <div class="content-column col-lg-8 col-md-12 col-sm-12">
                        @include('Candidate::frontend.layouts.details.candidate-detail')
                    </div>
                    <div class="sidebar-column col-lg-4 col-md-12 col-sm-12">
                        <div class="sidebar">
                            @include('Candidate::frontend.layouts.details.candidate-sidebar')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End candidate Detail Section -->
</div>
