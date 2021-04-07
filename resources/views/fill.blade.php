@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Fill Survey {{ ($survey) ? '('. $survey->name .')' : '' }}</div>
                    <div class="panel-body">
                        <form class="form-horizontal form" role="form" method="POST" action="{{ route('save-form') }}">
                            {{ csrf_field() }}
                            @php
                                $surveyAttributesCount = ($survey) ? count($survey->surveyAttributes) : 0;
                            @endphp
                            <input type="hidden" name="survey_id" value="{{ ($survey) ? $survey->id : 0 }}">
                            <input type="hidden" name="method" id="method" value="save">
                        @if($survey)
                               @if($surveyAttributesCount)
                                    @foreach($survey->surveyAttributes as $surveyAttribute)
                                        @if($surveyAttribute->label_type == 'checkbox')
                                            @include('partials.checkbox', ['attribute' => $surveyAttribute])
                                        @elseif($surveyAttribute->label_type == 'text_field')
                                            @include('partials.textfield', ['attribute' => $surveyAttribute])
                                        @elseif($surveyAttribute->label_type == 'radio_button')
                                            @include('partials.radiobutton', ['attribute' => $surveyAttribute])
                                        @elseif($surveyAttribute->label_type == 'text_area')
                                            @include('partials.textarea', ['attribute' => $surveyAttribute])
                                        @elseif($surveyAttribute->label_type == 'dropdown')
                                            @include('partials.dropdown', ['attribute' => $surveyAttribute])
                                        @endif
                                    @endforeach
                               @endif

                            <div class="form-group">
                                <div class="col-md-4 col-md-offset-4">
                                    <button type="button" class="btn btn-primary submit-form"  btn-type="save">Save</button>
                                    <button type="button" class="btn btn-success submit-form"  btn-type="submit">Submit</button>
                                </div>
                            </div>
                            @else
                                <span>Survey Not Found!</span>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script>
    $(document).ready(function(){
        $(document).on('click','.submit-form', function(e){
            var method = $(this).attr('btn-type');
            if(method) {
                $("#method").val(method);
            }
            if(method == 'submit') {
                var $fields = $(".form :input");
                var $emptyFields = $fields.filter(function() {
                    if(this.type == 'checkbox') {
                        return $("input[name='"+ this.name +"']:checked").length === 0;
                    }
                    else if(this.type != 'button') {
                        return $.trim(this.value) === "";
                    }
                    return false;
                });
                if (!$emptyFields.length) {
                    $(".form").submit();
                } else {
                    alert("You forgot to fill something out");
                }
            }
            else {
                $(".form").submit();
            }

        });
    });
</script>
@endsection