@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <div class="form-row">
                        <div class="col-sm-10"><h6>Project User List</h6></div>
                        {{-- <div class="col-sm-2 text-end">
                        <a type="button" name="back" class="btn btn-sm btn-outline-info" href="{{ url('projects/' . $project_id . '/index') }}">
                            Back
                        </a>
                        </div> --}}
                    </div>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <project_users-component :project_id={{$project->id}}></project_users-component>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>

    function activeMenu() {
        // var element1 = document.getElementById("data-analysis-list");
        // element1.classList.add("menu-open");
    
        document.getElementById("settings-list").classList.add("menu-open");
        document.getElementById("settings-link").classList.add("active");
        document.getElementById("project-users-link").classList.add("active");
        
    }
    //     $(document).ready( function() {
    //   $('#data-analysis-list').addClass( 'menu-open' );
    // } );
    </script>