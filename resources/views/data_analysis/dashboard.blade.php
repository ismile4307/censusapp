@extends('layouts.app')

@section('style')


@endsection
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <dashboard-component :project_id={{$project->id}}></dashboard-component>
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
    document.getElementById("dashboard-link").classList.add("active");
    
}
// $('[data-widget="pushmenu"]').PushMenu("collapse");
// var clickEvent = new MouseEvent("click", {
//     "view": window,
//     "bubbles": true,
//     "cancelable": false
// });

// var clickEvent = document.createEvent("MouseEvent");
// clickEvent.initMouseEvent("click", true, true, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);

// var element = document.getElementById('fullscreen');
// element.dispatchEvent(clickEvent);

// window.resizeTo(1920, 1080);
//     $(document).ready( function() {
//   $('#data-analysis-list').addClass( 'menu-open' );
// } );
</script>

