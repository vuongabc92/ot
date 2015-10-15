@extends('backend::layouts._backend')

@section('content')

<h3>List all users</h3>
<table class="table table-bordered table-hover table-responsive table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Role</th>
            <th width="50px">Status</th>
            <th width="130px">Last modified</th>
            <th width="130px">Actions</th>
        </tr>
    </thead>
    <tbody>

        @foreach($roles as $role)
        <tr>
            <td>#</td>
            <td>{{ $role->name }}</td>
            <td>{{ $role->role }}</td>
            <td>
                @if($role->is_active)
                <a class="label label-success _fs11" href="#">Active</a>
                @else
                <a class="label label-danger _fs11" href="#">Disable</a>
                @endif
            </td>
            <td>{{ 1 }}</td>
            <td>
                <a href="#" class="btn btn-warning btn-sm">Edit</a>
                <a href="#" class="btn btn-danger btn-sm">Delete</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="_fwfl">
    <a class="btn btn-default _r2" href="#"> + Add new user</a>
</div>
@stop