@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        
        <div class="row">
            <div class="col-12">
                <div class="card mt-4">
                    <div class="card-header">
                        {{ __('User Management') }}
                        <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm float-right">Add User</a>
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = ($users->perPage() * ($users->currentPage() - 1)) + 1;
                                @endphp
                                @foreach($users as $user)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>
                                        {{ $user->name }}
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        
                                        <form style="display: inline;" method="POST" action="{{ route('users.destroy', $user->id) }}">
                                            @method("DELETE")
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
     
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-3">
                            {!! $users->links() !!}      
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
@endsection
