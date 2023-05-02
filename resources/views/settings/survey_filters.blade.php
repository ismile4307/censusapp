@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <survey_filters-component :project_id={{$project->id}}></survey_filters-component>
            {{-- <div class="card">
                <div class="card-header">{{ __('Frequency Table') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div> --}}
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
        document.getElementById("survey-finters-link").classList.add("active");
        
    }
    //     $(document).ready( function() {
    //   $('#data-analysis-list').addClass( 'menu-open' );
    // } );
    </script>
