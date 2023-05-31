@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Change Password') }}</div>

                <div class="card-body">
                    <form name="myForm"  method="POST" action="{{ route('change_password') }}" onsubmit="return validateForm()">
                        @csrf
                        <div class="row text-center">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                            @if($errors->any())
                                <div class="alert alert-danger p-2" role="alert">
                                {{$errors->first()}}
                            </div>
                            @endif
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                        <div class="row mb-3">
                            <label for="password-old" class="col-md-4 col-form-label text-md-end">{{ __('Old Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-old" type="password" class="form-control @error('password') is-invalid @enderror" name="password_old" required autocomplete="new-password">

                                @error('password-old')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-new" class="col-md-4 col-form-label text-md-end">{{ __('New Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-new" type="password" class="form-control @error('password') is-invalid @enderror" name="password_new" required autocomplete="new-password">

                                @error('password-new')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4 text-center">
                                <a type="button" class="btn btn-sm btn-primary mr-2" href="{{ url('/home') }}">
                                    {{ __('Back') }}
                                </a>
                                <button type="submit" class="btn btn-sm btn-success">
                                    {{ __('Save') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js"></script>  
<script>
    function validateForm() {
        let password_old = document.forms["myForm"]["password-old"].value;
        if (password_old.length <8) {
            swal("Minium 8 charecter should be requried for old password");
            return false;
        }
        let password_new = document.forms["myForm"]["password-new"].value;
        if (password_new.length <8) {
            swal("Minium 8 charecter should be requried for new password");
            return false;
        }
        let password_confirm = document.forms["myForm"]["password-confirm"].value;
        if (password_new!=password_confirm) {
            swal("New and Confirm password must be same");
            return false;
        }
    }
</script>
