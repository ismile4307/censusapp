@extends('layouts.main')

@section('content')

    <main class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-header">{{__('User Settings')}}</div>
                        
                        <div class="card-body">
                            <form method="POST" action="{{ URL::to('user/' . $user->id . '/update') }}">
                                @csrf
                                {{-- //*********************************************** 1st Row ************************************             --}}
                                <div class="form-group row" style="margin-bottom: 10px;">
                                    <div class="form-row row">
                                        <label for="user_name" class="col-sm-4 col-form-label col-form-label-sm text-sm-end">{{ __('User Name') }}</label>
            
                                        <div class="col-sm-8">
                                            <input id="user_name" type="text" class="form-control form-control-sm @error('user_name') is-invalid @enderror" name="user_name" value="{{ old('user_name', $user->name) }}" required autocomplete="user_name" autofocus>
            
                                            @error('user_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row" style="margin-bottom: 10px;">
                                    <div class="form-row row">
                                        <label for="email" class="col-sm-4 col-form-label col-form-label-sm text-sm-end">{{ __('Email') }}</label>

                                        <div class="col-sm-8">
                                            <input id="email" type="text" class="form-control form-control-sm @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" required autocomplete="email" autofocus>
            
                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row" style="margin-bottom: 10px;">
                                    <div class="form-row row">
                                        <label for="organization" class="col-sm-4 col-form-label col-form-label-sm text-sm-end">{{ __('Organization') }}</label>

                                        <div class="col-sm-8">
                                            <select class="form-control form-control-sm  @error('organization') is-invalid @enderror" id="organization" name="organization_id">
                                                <option Value="0">Select Organization</option>
                                                @foreach ($organizations as $organization)
                                                @if($organization->id==$user->organization_id)
                                                <option selected="selected" Value="{{ $organization->id }}">{{ $organization->org_name }}</option>    
                                                @else
                                                <option Value="{{ $organization->id }}">{{ $organization->org_name }}</option>    
                                                @endif
                                                @endforeach
                                                </select>
            
                                                @error('organization')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row" style="margin-bottom: 10px;">
                                    <div class="form-row row">
                                        <label for="user_type" class="col-sm-4 col-form-label col-form-label-sm text-sm-end">{{ __('User Type') }}</label>

                                        <div class="col-sm-8">
                                            <select class="form-control form-control-sm  @error('user_type') is-invalid @enderror" id="user_type" name="user_type_id">
                                                <option Value="0">Select User Type</option>
                                                @foreach ($user_types as $user_type)
                                                @if ($user_type->id==$user->user_type_id)
                                                <option selected="selected" Value="{{ $user_type->id }}">{{ $user_type->user_type }}</option>
                                                @else
                                                <option Value="{{ $user_type->id }}">{{ $user_type->user_type }}</option>
                                                @endif
                                                
                                                @endforeach
                                                </select>
            
                                                @error('user_type')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row" style="margin-bottom: 10px;">
                                    <div class="form-row row">
                                        <label for="status" class="col-sm-4 col-form-label col-form-label-sm text-sm-end">{{ __('Status') }}</label>

                                        <div class="col-sm-8">
                                            <select class="form-control form-control-sm  @error('status') is-invalid @enderror" id="status" name="status">
                                                <option Value="0">Select Status</option>
                                                {{-- @foreach ($User_Types as $User_Type)
                                                <option Value="{{ $User_Type->id }}">{{ $User_Type->user_type }}</option>
                                                @endforeach --}}
                                                @if ($user->status==1)
                                                <option selected="selected" Value=1>Active</option>
                                                <option Value=0>Inactive</option>
                                                @else
                                                <option Value=1>Active</option>
                                                <option selected="selected" Value=0>Inactive</option>
                                                @endif
                                                
                                                
                                            </select>
            
                                            @error('status')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- <div class="row mb-3">
                                    <label for="password" class="col-sm-4 col-form-label text-sm-end">{{ __('Password') }}</label>
        
                                    <div class="col-sm-6">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
        
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
        
                                <div class="row mb-3">
                                    <label for="password-confirm" class="col-sm-4 col-form-label text-sm-end">{{ __('Confirm Password') }}</label>
        
                                    <div class="col-sm-6">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div> --}}

                                <hr class="mt-2 mb-3"/>

                                <div class="row">
                                    <div class="col-sm-12 text-center">
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            {{ __('Update') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    {{-- <script type="text/javascript">
        $('.date').datepicker({  
           format: 'mm-dd-yyyy'
         });  
    </script>     --}}
@endsection
