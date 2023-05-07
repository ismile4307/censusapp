@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card border-info">
                <div class="card-header text-bg-info text-center"><span style="font-size: large">Project List</span></div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="row col d-flex justify-content-center">
                            @if($projects!=null)
                                @foreach($projects as $project)
                                    <div class="col-sm-3 mb-3 mb-sm-0">
                                        <div class="card text-center text-bg-{{$project->class_name}}">
                                            <div class="card-body">
                                                <h4 class="card-title">{{$project->project_name}}</h4>
                                                <p class="card-text">{{$project->project_type}}</p>
                                            </div>
                                            <div class="card-footer bg-transparent"><a href="{{'/project/'.$project->id.'/info'}}" class="btn btn-sm btn-{{$project->class_name}}">More Info-></a></div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <h5 class="text-center">No assigned project is found !!!</h5>
                            @endif


                            {{-- <div class="col-sm-3 mb-3 mb-sm-0">
                                <div class="card text-center text-bg-warning">
                                    <div class="card-body">
                                        <h4 class="card-title">Teaf</h4>
                                        <p class="card-text">FCMP & Tea Study</p>
                                    </div>
                                    <div class="card-footer bg-transparent"><a href="{{'/project/2/info'}}" class="btn btn-sm btn-warning">More Info</a></div>
                                </div>
                            </div>
                            <div class="col-sm-3 mb-3 mb-sm-0">
                                <div class="card text-center text-bg-success">
                                    <div class="card-body">
                                        <h4 class="card-title">TWS</h4>
                                        <p class="card-text">Ad Hoc</p>
                                    </div>
                                    <div class="card-footer bg-transparent"><a href="{{'/project/3/info'}}" class="btn btn-sm btn-success">More Info</a></div>
                                </div>
                            </div> --}}
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
