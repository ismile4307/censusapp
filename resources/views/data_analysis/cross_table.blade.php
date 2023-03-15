@extends('layouts.app')

@section('style')
    <!-- Styles Created By Ismile -->
    <link href="/assets/css/table.css" rel="stylesheet">
    {{-- <link href="/assets/css/table_kpi.css" rel="stylesheet"> --}}
    {{-- <link href="{{ asset('public/css/app.css') }}" rel="stylesheet"> --}}
    


    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script> --}}

    <style>
    .table-container {
    /* width: 300px; */
    height: 380px;
    /* overflow: scroll; */
    overflow: auto;
    }
    th {background-color:white;} 
    th:first-child, td:first-child {
      position:sticky;
      left:0;
      z-index:1;
      background-color:white;
    }
    thead tr th {
      position:sticky;
      top:0;
    }
    th:first-child {
      z-index:2;background-color:white;
    }


    a:visited,
    a:focus {
    background: rgb(24, 194, 154);
    color: black;
    }

</style>
  
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <cross_table-component :project_id={{$project->id}}></cross_table-component>
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
    
        document.getElementById("data-analysis-list").classList.add("menu-open");
        document.getElementById("data-analysis-link").classList.add("active");
        document.getElementById("cross-table-link").classList.add("active");
        
    }
    //     $(document).ready( function() {
    //   $('#data-analysis-list').addClass( 'menu-open' );
    // } );
    </script>
