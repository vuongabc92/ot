@extends('backend::layouts._backend')

@section('content')

<h3 class="_tg6 _fs20 add-title">{{ _t('backend_co_new') }}</h3>
<hr />
{!! Form::model($category_one, ['url' => route('backend_co_save', $slug), 'role' => 'form', 'files' => true]) !!}
    @if($category_one->id !== null) {!! Form::hidden('id', $category_one->id) !!} @endif
    <div class="form-group">
        <label for="name">{!! error_or_label( _t('backend_co_name'), 'name') !!}</label>
        {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name', 'placeholder' => _t('backend_co_name')]) !!}
    </div>
    <div class="form-group">
        <label for="slug">{!! error_or_label( _t('backend_co_image'), 'image') !!}</label>
        @if(check_file($image_path . $category_one->image))
            <img src="{{ asset($image_path . $category_one->image) }}" class="image-image img-responsive _r2"/>
        @endif
        <div class="_mt10">
            {!! Form::file('image', ['class' => '', 'id' => 'image', 'accept' => 'image/*']) !!}
        </div>
    </div>
    <hr />
    <button type="submit" class="btn btn-default _r2">{{ _t('backend_common_save') }}</button>
{!! Form::close() !!}

@stop