@extends('layouts.app')
<style>
    .background-light-gray {
        background-color:lightgray;
    }
    .background-lightcyan {
        background-color:lightcyan;
    }
</style>
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">View Survey {{ ($surveyNameAndSubmittedTime) ? ' (' . $surveyNameAndSubmittedTime->name . ')' : ''}}</div>
                    <div class="panel-body">
                        <div class="row" style="padding: 25px;">
                            @if(count($submittedSurvey) > 0)
                                @foreach($submittedSurvey as $attribute)
                                    <div class="col-sm-5 col-md-4 background-light-gray">{{ $attribute->label }}</div>
                                    <div class="col-sm-5 col-sm-offset-2 col-md-8 col-md-offset-0 background-lightcyan">{{ $attribute->value }}</div>
                                @endforeach
                            @else
                                <span>Survey Not Found!</span>
                            @endif
                        </div>
                        @if($surveyNameAndSubmittedTime)
                            <span><b>Submitted at:</b>  {{ date('d M Y', strtotime($surveyNameAndSubmittedTime->submitted_at)) }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection