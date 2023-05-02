@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card border-info">
                <div class="card-header text-bg-info text-center"><span style="font-size: large">Porject Info</span></div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-info" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="text-center">
                            <h2><b>Project Name : {{$project->project_name}}</b></h2>
                            <h3>Total Sample : 2652</h3>
                            <h3>Total Center : 08</h3>
                            <h4>Project Duratoin : 11.03.2023 - 19.03.2023</h4>
                            {{-- <h4>Fieldwork By : DBI Research Privte Ltd.</h4> --}}
                        </div>

                    </div>
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
    
        document.getElementById("project-info-list").classList.add("menu-open");
        document.getElementById("project-info-list").classList.add("active");
        
        
    }
    //     $(document).ready( function() {
    //   $('#data-analysis-list').addClass( 'menu-open' );
    // } );
    </script>
