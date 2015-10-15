@extends('backend::layouts._backend')

@section('content')

<h3 class="_tg6 _fs20">{{ _t('backend_role_all') }}</h3>
<hr />
<table class="table table-bordered table-hover table-responsive table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>{{ _t('backend_role_name') }}</th>
            <th>{{ _t('backend_role') }}</th>
            <th width="50px">{{ _t('backend_role_status') }}</th>
            <th width="120px">{{ _t('backend_role_last') }}</th>
            <th width="130px">{{ _t('backend_role_actions') }}</th>
        </tr>
    </thead>
    <tbody>
        @set $i = 0
        @foreach($roles as $role)
            @set $i = $i + 1
        <tr>
            <td>{{ $i }}</td>
            <td>{{ $role->name }}</td>
            <td>{{ $role->role }}</td>
            <td>
                @if($role->is_active)
                <a class="label label-success _fs11" href="#">{{ _t('backend_common_active') }}</a>
                @else
                <a class="label label-danger _fs11" href="#">{{ _t('backend_common_disable') }}</a>
                @endif
            </td>
            <td>{{ time_format($role->updated_at, 'd/m/Y') }}</td>
            <td>
                <a href="#" class="btn btn-warning btn-sm _r2">{{ _t('backend_common_edit') }}</a>
                <a href="#" class="btn btn-danger btn-sm _r2">{{ _t('backend_common_delete') }}</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="_fwfl">
    <a class="btn btn-default _r2" href="#">{{ _t('backend_role_new') }}</a>
</div>
@stop