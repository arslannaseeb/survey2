@extends('layouts.app')

@section('content')
    <!-- Surveys -->
    <!-- @if (count($surveys) > 0) -->
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
            <div class="panel-heading">
                Surveys
            </div>

            <div class="panel-body">
                <table class="table table-striped task-table">

                    <!-- Table Headings -->
                    <thead>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Created at</th>
                    <th>Action Link</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                    @foreach ($surveys as $survey)
                        <tr>
                            <!-- Task Name -->
                            <td class="table-text">
                                <div>{{ $survey->name }}</div>
                            </td>
                            <td>
                                <div>{{ $survey->description }}</div>
                            </td>
                            <td>
                                <div>{{ $survey->status }}</div>
                            </td>
                            <td>
                                <div>{{ $survey->created_at }}</div>
                            </td>
                            @php
                                $link = route('fill-form', [$survey->id]);
                                $linkText = 'Fill';
                                if($survey->status == 'Completed')
                                {
                                    $link = route('view-form', [$survey->id]);
                                    $linkText = 'View';
                                }
                            @endphp
                            <td>
                                <div><a href="{{ $link }}">{{ $linkText }}</a></div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
            </div>
        </div>
    <!-- @endif -->
@endsection
