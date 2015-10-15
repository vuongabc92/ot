@extends('backend::layouts._backend')

@section('content')

<h3 class="_tg6 _fs20">Add New Role</h3>
<hr />
{!! Form::open(['url' => '']) !!}
<form role="form">
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" placeholder="Name">
    </div>
    <div class="form-group">
        <label for="role">Role</label>
        <input type="text" class="form-control" id="role" placeholder="Role">
    </div>
    <button type="submit" class="btn btn-default _r2">Save</button>
</form>

@stop