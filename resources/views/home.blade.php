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
                            <div class="col-sm-3 mb-3 mb-sm-0">
                                <div class="card text-center text-bg-primary">
                                    <div class="card-body">
                                        <h4 class="card-title">Fortify 2</h4>
                                        <p class="card-text">Cement Census</p>
                                    </div>
                                    <div class="card-footer bg-transparent"><a href="{{'/project/1/info'}}" class="btn btn-sm btn-primary">More Info</a></div>
                                </div>
                            </div>
                            <div class="col-sm-3 mb-3 mb-sm-0">
                                <div class="card text-center text-bg-warning">
                                    <div class="card-body">
                                        <h4 class="card-title">Project Name 1</h4>
                                        <p class="card-text">Study Type</p>
                                    </div>
                                    <div class="card-footer bg-transparent"><a href="#" class="btn btn-sm btn-warning">More Info</a></div>
                                </div>
                            </div>
                            <div class="col-sm-3 mb-3 mb-sm-0">
                                <div class="card text-center text-bg-success">
                                    <div class="card-body">
                                        <h4 class="card-title">Project Name 2</h4>
                                        <p class="card-text">Study Type</p>
                                    </div>
                                    <div class="card-footer bg-transparent"><a href="#" class="btn btn-sm btn-success">More Info</a></div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
