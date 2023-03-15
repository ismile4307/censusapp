@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <advanced_analysis-component></advanced_analysis-component>
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
    document.getElementById("advanced-analysis-link").classList.add("active");
    
}
//     $(document).ready( function() {
//   $('#data-analysis-list').addClass( 'menu-open' );
// } );
</script>

