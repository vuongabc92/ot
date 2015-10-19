@extends('backend::layouts._backend')

@section('content')

<h3 class="_tg6 _fs20">{{ _t('backend_pc_list') }}</h3>
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
            <th>{{ _t('backend_pc_name') }}</th>
            <th>{{ _t('backend_pc_slug') }}</th>
            <th width="50px">{{ _t('backend_common_status') }}</th>
            <th width="130px">{{ _t('backend_common_actions') }}</th>
        </tr>
    </thead>
    <tbody>
        @set $i = 0
        @foreach($post_categories as $category)
            @set $i = $i + 1
        <tr>
            <td>{{ $i }}</td>
            <td>{{ $category->name }}</td>
            <td><a href="{{route('backend_users_by_role', $category->id) }}">{{ $category->slug }}</a></td>
            <td>
                @if($category->is_active)
                <a class="label label-success _fs11 _r2" href="{{ route('backend_pc_active', $category->id) }}">{{ _t('backend_common_active') }}</a>
                @else
                <a class="label label-danger _fs11 _r2" href="{{ route('backend_pc_active', $category->id) }}">{{ _t('backend_common_disable') }}</a>
                @endif
            </td>
            <td>
                <a href="{{ route('backend_pc_edit', $category->id) }}" class="btn btn-warning btn-sm _r2 _mb3">{{ _t('backend_common_edit') }}</a>
                <a href="{{ route('backend_pc_delete', ['id' => $category->id, 'token' => csrf_token()]) }}" class="btn btn-danger btn-sm _r2" onclick="return confirm('{{ _t('backend_pc_delete_one') }}')">{{ _t('backend_common_delete') }}</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="_fwfl">
    <a class="btn btn-default _r2" href="{{ route('backend_pc_add') }}">{{ _t('backend_pc_new') }}</a>
</div>
@stop