@extends('backend::layouts._backend')

@section('content')

<h3 class="_tg6 _fs20 add-title">{{ _t('backend_image_new') }}</h3>
<hr />
{!! Form::model($image, ['url' => route('backend_image_save', $slug), 'role' => 'form', 'files' => true]) !!}
    @if($image->id !== null) {!! Form::hidden('id', $image->id) !!} @endif
    <div class="form-group">
        <label for="name">{!! error_or_label( _t('backend_image_name'), 'name') !!}</label>
        {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name', 'placeholder' => _t('backend_image_name')]) !!}
    </div>
    <div class="form-group">
        <label for="image">{!! error_or_label( _t('backend_image_image'), 'image') !!}</label>
        @if(check_file(config('back.image_path') . $image->image))
            <img src="{{ asset(config('back.image_path') . $image->image) }}" class="image-image img-responsive _r2"/>
        @endif
        <div class="_mt10">
            {!! Form::file('image') !!}
        </div>
        <hr />
    </div>
    <button type="submit" class="btn btn-default _r2">{{ _t('backend_common_save') }}</button>
{!! Form::close() !!}

@stop