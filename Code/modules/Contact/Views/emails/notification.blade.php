@extends('Email::layout')
@section('content')

    <div class="b-container">
        <div class="b-panel">
            <h3 class="email-headline"><strong>{{__('Hello, ')}}</strong></h3>
            <p>{{__('Here are new contact information:')}}</p>
            <br>
            <div class="b-panel">
                <div class="b-table-wrap">
                    <table class="b-table" cellspacing="0" cellpadding="0">
                        <tr class="info-first-name">
                            <td class="label">{{__('Name')}}</td>
                            <td class="val">{{$contact->name}}</td>
                        </tr>
                        <tr class="info-first-name">
                            <td class="label">{{__('Email')}}</td>
                            <td class="val">{{$contact->email}}</td>
                        </tr>
                        <tr class="info-first-name">
                            <td class="label">{{__('Message')}}</td>
                            <td class="val">{{$contact->message}}</td>
                        </tr>
                        @if(!empty($contact->job))
                            <tr class="info-first-name">
                                <td class="label">{{__('Job')}}</td>
                                <td class="val"><a href="{{ $contact->job->getDetailUrl() }}" target="_blank">{{$contact->job->title}}</a></td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection
