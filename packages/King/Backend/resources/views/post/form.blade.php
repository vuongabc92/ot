@extends('backend::layouts._backend', ['active' => 'post-' . $slug])

@section('title')
    @if($post->id !== null) 
        {{ _t('backend_post') }} > {{ _t('backend_common_edit') }} |
    @else
        {{ _t('backend_post') }} > {{ _t('backend_common_add') }} |
    @endif
@stop

@section('content')

<h3 class="_tg6 _fs20 add-title">{{ _t('backend_post_new') }}</h3>
<hr />
{!! Form::model($post, ['url' => route('backend_post_save', $slug), 'role' => 'form', 'files' => true]) !!}
    @if($post->id !== null) {!! Form::hidden('id', $post->id) !!} @endif
    <div class="form-group">
        <label for="name">{!! error_or_label( _t('backend_post_name'), 'name') !!}</label>
        {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name', 'placeholder' => _t('backend_post_name')]) !!}
    </div>
    <div class="form-group">
        <label for="image">{!! error_or_label( _t('backend_post_image'), 'image') !!}</label>
        @if(check_file(config('back.post_path') . $post->image))
            <img src="{{ asset(config('back.post_path') . $post->image) }}" class="post-image img-responsive _r2"/>
        @endif
        <div class="_mt10">
            {!! Form::file('image', ['class' => '', 'id' => 'image', 'accept' => 'image/*']) !!}
        </div>
    </div>
    <div class="form-group">
        <label for="_tinymce">{!! error_or_label( _t('backend_post_content'), 'content') !!}</label>
        {!! Form::textarea('content', null, ['class' => 'form-control', 'id' => '_tinymce', 'placeholder' => _t('backend_post_content')]) !!}
    </div>
    <button type="submit" class="btn btn-default _r2">{{ _t('backend_common_save') }}</button>
{!! Form::close() !!}

@stop