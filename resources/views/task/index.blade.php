@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        
        <div class="row">
            <div class="col-12">
                <div class="card mt-4">
                    <div class="card-header">
                        {{ __('Task Management') }}
                        @hasanyrole('Admin|Manager')
                            <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-sm float-right">Add Task</a>
                        @endhasanyrole
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Assigned To</th>
                                    <th>Done</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = ($tasks->perPage() * ($tasks->currentPage() - 1)) + 1;
                                @endphp
                                @foreach($tasks as $task)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>
                                        {{ $task->name }}
                                    </td>
                                    <td>{{ $task->description }}</td>
                                    <td>{{ $task->assignedUser->name }}</td>
                                    <td>
                                        @if($task->done)
                                            <span class="badge badge-success">Yes</span>
                                        @else
                                            <span class="badge badge-danger">No</span>
                                        @endif
                                    </td>
                                    <td>
                                        @can('edit-tasks')
                                            <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                        @endcan
                                        @can('delete-tasks')
                                        <form style="display: inline;" method="POST" action="{{ route('tasks.destroy', $task->id) }}">
                                            @method("DELETE")
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                        @endcan
                    
                                        <form style="display: inline;" method="POST" action="{{ route('tasks.mark-done', $task->id) }}">
                                            @method("PUT")
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-info">Mark Done</button>
                                        </form>
     
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-3">
                            {!! $tasks->links() !!}      
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
@endsection
