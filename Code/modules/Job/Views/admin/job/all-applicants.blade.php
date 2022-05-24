@extends('admin.layouts.app')
@section('title','All Applicants')
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb-4">
            <h1 class="title-bar">{{__("All Applicants")}}</h1>
        </div>
        @include('admin.message')
        <div class="filter-div d-flex justify-content-between ">
            <div class="col-left">
                @if(!empty($rows))
                    <form method="post" action="{{ route('job.admin.applicants.bulkEdit') }}" class="filter-form filter-form-left d-flex justify-content-start">
                        {{csrf_field()}}
                        <select name="action" class="form-control">
                            <option value="">{{__(" Bulk Actions ")}}</option>
                            <option value="approved">{{__("Approved")}}</option>
                            <option value="rejected">{{__("Rejected")}}</option>
                        </select>
                        <button data-confirm="{{__("Do you want to delete?")}}" class="btn-info btn btn-icon dungdt-apply-form-btn" type="button">{{__('Apply')}}</button>
                        <a class="btn btn-warning btn-icon" href="{{ route('job.admin.applicants.export') }}"
                           target="_blank" title="{{ __("Export to excel") }}"><i class="icon ion-md-cloud-download"></i>&nbsp;{{ __("Export") }}
                        </a>
                    </form>
                @endif
            </div>
            <div class="col-left">
                <form method="get" action="{{ route("job.admin.allApplicants") }} " class="filter-form filter-form-right d-flex justify-content-end flex-column flex-sm-row" role="search">
                    @if(is_admin())
                        <?php
                        $company = \Modules\Company\Models\Company::find(Request()->input('company_id'));
                        \App\Helpers\AdminForm::select2('company_id', [
                            'configs' => [
                                'ajax'        => [
                                    'url' => route('company.admin.getForSelect2'),
                                    'dataType' => 'json'
                                ],
                                'allowClear'  => true,
                                'placeholder' => __('-- Select Company --')
                            ]
                        ], !empty($company->id) ? [
                            $company->id,
                            $company->name . ' (#' . $company->id . ')'
                        ] : false);

                        $candidate = \App\User::find(Request()->input('candidate_id'));
                        \App\Helpers\AdminForm::select2('candidate_id', [
                            'configs' => [
                                'ajax'        => [
                                    'url' => route('candidate.admin.getForSelect2'),
                                    'dataType' => 'json'
                                ],
                                'allowClear'  => true,
                                'placeholder' => __('-- Select Candidate --')
                            ]
                        ], !empty($candidate->id) ? [
                            $candidate->id,
                            $candidate->getDisplayName() . ' (#' . $candidate->id . ')'
                        ] : false)
                        ?>
                    @endif
                    @php
                        $job = \Modules\Job\Models\Job::find(Request()->input('job_id'));
                        \App\Helpers\AdminForm::select2('job_id', [
                            'configs' => [
                                'ajax'        => [
                                    'url' => route('job.admin.getForSelect2'),
                                    'dataType' => 'json'
                                ],
                                'allowClear'  => true,
                                'placeholder' => __('-- Select Job --')
                            ]
                        ], !empty($job->id) ? [
                            $job->id,
                            $job->title . ' (#' . $job->id . ')'
                        ] : false);
                    @endphp

                    <button class="btn-info btn btn-icon btn_search" type="submit">{{__('Search')}}</button>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-body">
                        <form action="" class="bravo-form-item">
                            <div class="table-responsive">
                                <table class="table table-hover table-vertical-middle">
                                    <thead>
                                    <tr>
                                        <th width="60px"><input type="checkbox" class="check-all"></th>
                                        <th class="title"> {{ __('Candidate')}}</th>
                                        <th> {{ __('Job Title')}}</th>
                                        <th width="150px"> {{ __('CV')}}</th>
                                        <th width="150px"> {{ __('Date Applied')}}</th>
                                        <th width="100px"> {{ __('Status')}}</th>
                                        <th width="100px"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($rows->total() > 0)
                                        @foreach($rows as $row)
                                            <tr class="{{$row->status}}">
                                                <td><input type="checkbox" name="ids[]" class="check-item" value="{{$row->id}}">
                                                </td>
                                                <td>
                                                    @if(!empty($row->candidateInfo->getAuthor->getDisplayName()))
                                                        <a href="{{ $row->candidateInfo->getDetailUrl() }}" target="_blank">
                                                            <img src="{{ $row->candidateInfo->getAuthor->getAvatarUrl() }}" style="border-radius: 50%" class="company-logo" />
                                                            {{$row->candidateInfo->getAuthor->getDisplayName() ?? ''}}
                                                        </a>
                                                    @endif
                                                </td>
                                                <td class="title">
                                                    <a href="{{ $row->jobInfo->getDetailUrl() }}" target="_blank">{{$row->jobInfo->title}}</a>
                                                </td>
                                                <td>
                                                    @if(!empty($row->cvInfo->file_id))
                                                        @php $file = (new \Modules\Media\Models\MediaFile())->findById($row->cvInfo->file_id) @endphp
                                                        <a href="{{ \Modules\Media\Helpers\FileHelper::url($row->cvInfo->file_id) }}" target="_blank" download>
                                                            {{ $file->file_name.'.'.$file->file_extension }}
                                                        </a>
                                                    @endif
                                                </td>
                                                <td>{{ display_date($row->created_at) }}</td>
                                                <td><span class="badge badge-{{ $row->status }}">{{ $row->status }}</span></td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            {{ __("Actions") }}
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal-applied-{{ $row->id }}">{{ __("Detail") }}</a>
                                                            <a class="dropdown-item" href="{{ route('job.admin.applicants.changeStatus', ['status' => 'approved', 'id' => $row->id]) }}">{{ __("Approved") }}</a>
                                                            <a class="dropdown-item" href="{{ route('job.admin.applicants.changeStatus', ['status' => 'rejected', 'id' => $row->id]) }}">{{ __("Rejected") }}</a>
                                                        </div>
                                                    </div>
                                                    <div class="modal fade" id="modal-applied-{{ $row->id }}">
                                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                                            <div class="modal-content">

                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">{{ __("Applied Detail") }}</h4>
                                                                </div>

                                                                <div class="modal-body">
                                                                    <div class="info-form">
                                                                        <div class="applied-list">
                                                                            <div class="applied-item">
                                                                                <div class="label">{{ __("Candidate:") }}</div>
                                                                                <div class="val">
                                                                                    @if(!empty($row->candidateInfo->getAuthor->getDisplayName()))
                                                                                        <a href="{{ $row->candidateInfo->getDetailUrl() }}" target="_blank">
                                                                                            <img src="{{ $row->candidateInfo->getAuthor->getAvatarUrl() }}" style="border-radius: 50%" class="company-logo" />
                                                                                            {{$row->candidateInfo->getAuthor->getDisplayName() ?? ''}}
                                                                                        </a>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                            <div class="applied-item">
                                                                                <div class="label">{{ __('Job Title:') }}</div>
                                                                                <div class="val">
                                                                                    <a href="{{ $row->jobInfo->getDetailUrl() }}" target="_blank">{{$row->jobInfo->title}}</a>
                                                                                </div>
                                                                            </div>
                                                                            <div class="applied-item">
                                                                                <div class="label">{{ __("CV:") }}</div>
                                                                                <div class="val">
                                                                                    @if(!empty($row->cvInfo->file_id))
                                                                                        @php $file = (new \Modules\Media\Models\MediaFile())->findById($row->cvInfo->file_id) @endphp
                                                                                        <a href="{{ \Modules\Media\Helpers\FileHelper::url($row->cvInfo->file_id) }}" target="_blank" download>
                                                                                            {{ $file->file_name.'.'.$file->file_extension }}
                                                                                        </a>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                            <div class="applied-item">
                                                                                <div class="label">{{ __("Message:") }}</div>
                                                                                <div class="val">{{ $row->message }}</div>
                                                                            </div>
                                                                            <div class="applied-item">
                                                                                <div class="label">{{ __("Date Applied:") }}</div>
                                                                                <div class="val">{{ display_date($row->created_at) }}</div>
                                                                            </div>
                                                                            <div class="applied-item">
                                                                                <div class="label">{{ __("Status:") }}</div>
                                                                                <div class="val"><span class="badge badge-{{ $row->status }}">{{ $row->status }}</span></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <span class="btn btn-secondary" data-dismiss="modal">{{ __("Close") }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7">{{__("No data")}}</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </form>
                        {{$rows->appends(request()->query())->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
