@extends('backend::layouts._backend', ['active' => 'post-' . $slug])

@section('title')
    {{ _t('backend_post') }} |
@stop

@section('content')

<h3 class="_tg6 _fs20">{{ _t('backend_post_list') }}</h3>
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
            <th>{{ _t('backend_post_image') }}</th>
            <th>{{ _t('backend_post_name') }}</th>
            <th width="50px">{{ _t('backend_common_status') }}</th>
            <th width="120px">{{ _t('backend_common_last') }}</th>
            <th width="130px">{{ _t('backend_common_actions') }}</th>
        </tr>
    </thead>
    <tbody>
        @set $i = 0
        @foreach($posts as $post)
            @set $i = $i + 1
        <tr>
            <td>{{ $i }}</td>
            <td>
                @if( ! check_file($image_path . $post->image))
                    <span class="default-image default-post-img _r2 fa fa-image"></span>
                @else
                    <img src="{{ asset($image_path . $post->image) }}" class="post-image img-responsive _r2"/>
                @endif
            </td>
            <td>{{ $post->name }}</td>
            <td>
                @if($post->is_active)
                <a class="label label-success _fs11 _r2" href="{{ route('backend_post_active', ['slug' => $slug, 'id' => $post->id]) }}">{{ _t('backend_common_active') }}</a>
                @else
                <a class="label label-danger _fs11 _r2" href="{{ route('backend_post_active', ['slug' => $slug, 'id' => $post->id]) }}">{{ _t('backend_common_disable') }}</a>
                @endif
            </td>
            <td>{{ time_format($post->updated_at, 'd/m/Y') }}</td>
            <td>
                <a href="{{ route('backend_post_edit', ['slug' => $slug, 'id' => $post->id]) }}" class="btn btn-warning btn-sm _r2">{{ _t('backend_common_edit') }}</a>
                <a href="{{ route('backend_post_delete', ['slug' => $slug, 'id' => $post->id, 'token' => csrf_token()]) }}" class="btn btn-danger btn-sm _r2" onclick="return confirm('{{ _t('backend_post_delete_one') }}')">{{ _t('backend_common_delete') }}</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="_fwfl">
    <a class="btn btn-default _r2" href="{{ route('backend_post_add', $slug) }}">{{ _t('backend_post_new') }}</a>
</div>
@stop