@extends('layouts.app')
@section('style')
    <!-- Styles Created By Ismile -->
    <link href="/assets/css/table.css" rel="stylesheet">
    {{-- <link href="/assets/css/table_kpi.css" rel="stylesheet"> --}}
    {{-- <link href="{{ asset('public/css/app.css') }}" rel="stylesheet"> --}}
    
<!-- Latest compiled and minified CSS -->
{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css"> --}}

    {{-- <style>
        .table-container {
        /* width: 300px; */
        height: 385px;
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
    
    
        /* a:visited,
        a:focus {
        background: rgb(24, 194, 154);
        color: black;
        } */
    
    </style> --}}
  
@endsection
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <search_operation-component :project_id={{$project->id}}></search_operation-component>
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
@section('script')

<!-- Latest compiled and minified JavaScript -->
  {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> --}}
  {{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.bundle.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script> --}}


@endsection

<script>
function activeMenu() {
    // var element1 = document.getElementById("data-analysis-list");
    // element1.classList.add("menu-open");

    document.getElementById("data-analysis-list").classList.add("menu-open");
    document.getElementById("data-analysis-link").classList.add("active");
    document.getElementById("search-operation-link").classList.add("active");
    
}
//     $(document).ready( function() {
//   $('#data-analysis-list').addClass( 'menu-open' );
// } );
</script>



