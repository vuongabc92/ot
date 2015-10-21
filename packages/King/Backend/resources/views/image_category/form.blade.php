@extends('backend::layouts._backend')

@section('content')

<h3 class="_tg6 _fs20 add-title">{{ _t('backend_ic_new') }}</h3>
<hr />
{!! Form::model($image_category, ['url' => route('backend_ic_save'), 'role' => 'form']) !!}
    @if($image_category->id !== null) {!! Form::hidden('id', $image_category->id) !!} @endif
    <div class="form-group">
        <label for="name">{!! error_or_label( _t('backend_ic_name'), 'name') !!}</label>
        {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name', 'placeholder' => _t('backend_ic_name')]) !!}
    </div>
    <div class="form-group">
        <label for="slug">{!! error_or_label( _t('backend_ic_slug'), 'slug') !!}</label>
        {!! Form::text('slug', null, ['class' => 'form-control', 'id' => 'slug', 'placeholder' => _t('backend_ic_slug')]) !!}
    </div>
    <button type="submit" class="btn btn-default _r2">{{ _t('backend_common_save') }}</button>
{!! Form::close() !!}

@stop