@extends('layouts.main')

@section('content')
<div class="container" style="font-size: small">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{__('User Details')}}</div>
                
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{-- {{ __('You are logged in!') }} --}}
                    
                    <table class="table table-sm table-bordered">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Organization</th>
                            <th>User Type</th>
                            <th>User Status</th>
                            <th colspan="2" class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $key => $value)
                                <tr>
                                    <td>{{ $value->id }}</td>
                                    <td>{{ $value->name }}</td>
                                    <td>{{ $value->email }}</td>
                                    @if($value->organization==null)
                                    <td>Not Assigned</td>
                                    @else
                                    <td>{{ $value->organization->org_name }}</td>
                                    @endif
                                    @if($value->user_type==null)
                                    <td>Not Assigned</td>
                                    @else    
                                    <td>{{ $value->user_type->user_type }}</td>
                                    @endif
                                    @if($value->status==1)
                                    <td>Active</td>
                                    @else
                                    <td>Inactive</td>
                                    @endif
                                    <!-- we will also add show, edit, and delete buttons -->
                                    <td>
                        
                                        <!-- delete the shark (uses the destroy method DESTROY /sharks/{id} -->
                                        <!-- we will add this later since its a little more complicated than the other two buttons -->
                        
                                        <!-- show the shark (uses the show method found at GET /sharks/{id} -->
                                        {{-- <a class="btn btn-small btn-success" href="{{ URL::to('sharks/' . $value->id) }}">Show Details</a> --}}
                        
                                        <!-- edit this shark (uses the edit method found at GET /sharks/{id}/edit -->
                                        <a href="{{ URL::to('user/' . $value->id . '/edit') }}">Edit User</a>
                        
                                    </td>
                                    @if(Auth::user()->id==1)
                                        <td>
                            
                                            <!-- delete the shark (uses the destroy method DESTROY /sharks/{id} -->
                                            <!-- we will add this later since its a little more complicated than the other two buttons -->
                            
                                            <!-- show the shark (uses the show method found at GET /sharks/{id} -->
                                            {{-- <a class="btn btn-small btn-success" href="{{ URL::to('sharks/' . $value->id) }}">Show Details</a> --}}
                            
                                            <!-- edit this shark (uses the edit method found at GET /sharks/{id}/edit -->
                                            <a href="{{ URL::to('user/' . $value->id . '/reset_password/index') }}">Reset Password</a>
                            
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{-- Pagination --}}
                    {{-- <div class="d-flex justify-content-center"> --}}
                        {{-- {{ $users->links() }} --}}
                    {{-- </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
