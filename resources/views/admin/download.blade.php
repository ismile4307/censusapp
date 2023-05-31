@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Download') }}</div>

                <div class="card-body">
                    <form action="{{route('download')}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                <select id="selectpicker" class="form-control bg-white form-control-sm mr-2" name="project_code" id="project_code">
                                    <option value="0">Select Project</option>
                                    @foreach ($projects as $project)
                                    <option value="{{$project->project_code}}">{{$project->project_name}}</option>
                                    @endforeach
                            </select>
                            </div>
                            <div class="col-md-3">
                                <select id="selectpicker" class="form-control bg-white form-control-sm mr-2" name="table_type" id="table_type">
                                    <option :value="0" selected>Select Contact Type</option>
                                    <option :value="1">Data Table</option>
                                    <option :value="2">Link Table</option>
                                    <option :value="3">Data & Link Table</option>
                                </select>   
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-success btn-sm">Download</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

