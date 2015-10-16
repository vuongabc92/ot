@extends('backend::layouts._backend')

@section('content')

<h3 class="_tg6 _fs20">{{ _t('backend_role_list') }}</h3>
<hr />
@if(session()->has('success'))
    <div class="alert alert-success _r2">{{ session()->get('success') }}</div>
@endif
@if(session()->has('error'))
    <div class="alert alert-danger _r2">{{ session()->get('error') }}</div>
@endif
<table class="table table-bordered table-hover table-responsive table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>{{ _t('backend_auth_uname') }}</th>
            <th>{{ _t('backend_auth_email') }}</th>
            <th width="50px">{{ _t('backend_common_status') }}</th>
            <th width="120px">{{ _t('backend_common_last') }}</th>
            <th width="130px">{{ _t('backend_common_actions') }}</th>
        </tr>
    </thead>
    <tbody>
        @set $i = 0
        @foreach($users as $user)
            @set $i = $i + 1
        <tr>
            <td>{{ $i }}</td>
            <td>{{ $user->username }}</td>
            <td>{{ $user->email }}</td>
            <td>
                @if($user->is_active)
                <a class="label label-success _fs11 _r2" href="#">{{ _t('backend_common_active') }}</a>
                @else
                <a class="label label-danger _fs11 _r2" href="#">{{ _t('backend_common_disable') }}</a>
                @endif
            </td>
            <td>{{ time_format($user->updated_at, 'd/m/Y') }}</td>
            <td>
                <a href="{ route('backend_role_edit', $role->id) }" class="btn btn-warning btn-sm _r2">{{ _t('backend_common_edit') }}</a>
                <a href="{ route('backend_role_delete', ['id' => $role->id, 'token' => csrf_token()]) }" class="btn btn-danger btn-sm _r2" onclick="return confirm('{{ _t('backend_role_delete_one') }}')">{{ _t('backend_common_delete') }}</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="_fwfl">
    <a class="btn btn-default _r2" href="{{ route('backend_role_add') }}">{{ _t('backend_role_new') }}</a>
</div>
@stop