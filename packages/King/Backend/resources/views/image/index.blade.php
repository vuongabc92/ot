@extends('backend::layouts._backend', ['active' => 'image-' . $slug])

@section('title')
    {{ _t('backend_image_image') }} |
@stop

@section('content')

<h3 class="_tg6 _fs20">{{ _t('backend_image_list') }}</h3>
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
            <th>{{ _t('backend_image_image') }}</th>
            <th>{{ _t('backend_image_name') }}</th>
            <th width="50px">{{ _t('backend_common_status') }}</th>
            <th width="120px">{{ _t('backend_common_last') }}</th>
            <th width="130px">{{ _t('backend_common_actions') }}</th>
        </tr>
    </thead>
    <tbody>
        @set $i = 0
        @foreach($images as $image)
            @set $i = $i + 1
        <tr>
            <td>{{ $i }}</td>
            <td>
                @if( ! check_file($image_path . $image->image))
                    <span class="default-image default-image-img _r2 fa fa-image"></span>
                @else
                    <img src="{{ asset($image_path . $image->thumbnail) }}" class="image-image img-responsive _r2"/>
                @endif
            </td>
            <td>{{ $image->name }}</td>
            <td>
                @if($image->is_active)
                <a class="label label-success _fs11 _r2" href="{{ route('backend_image_active', ['slug' => $slug, 'id' => $image->id]) }}">{{ _t('backend_common_active') }}</a>
                @else
                <a class="label label-danger _fs11 _r2" href="{{ route('backend_image_active', ['slug' => $slug, 'id' => $image->id]) }}">{{ _t('backend_common_disable') }}</a>
                @endif
            </td>
            <td>{{ time_format($image->updated_at, 'd/m/Y') }}</td>
            <td>
                <a href="{{ route('backend_image_edit', ['slug' => $slug, 'id' => $image->id]) }}" class="btn btn-warning btn-sm _r2">{{ _t('backend_common_edit') }}</a>
                <a href="{{ route('backend_image_delete', ['slug' => $slug, 'id' => $image->id, 'token' => csrf_token()]) }}" class="btn btn-danger btn-sm _r2" onclick="return confirm('{{ _t('backend_image_delete_one') }}')">{{ _t('backend_common_delete') }}</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="_fwfl">
    <a class="btn btn-default _r2" href="{{ route('backend_image_add', $slug) }}">{{ _t('backend_image_new') }}</a>
</div>
@stop