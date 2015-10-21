@extends('backend::layouts._backend')

@section('content')

<h3 class="_tg6 _fs20 add-title">{{ _t('backend_meta_new') }}</h3>
<hr />
{!! Form::model($meta, ['url' => route('backend_meta_save'), 'meta' => 'form']) !!}
    @if($meta->id !== null) {!! Form::hidden('id', $meta->id) !!} @endif
    <div class="form-group">
        <label for="key">{!! error_or_label( _t('backend_meta_key'), 'key') !!}</label>
        {!! Form::text('key', null, ['class' => 'form-control', 'id' => 'key', 'placeholder' => _t('backend_meta_key')]) !!}
    </div>
    <div class="form-group">
        <label for="key_name">{!! error_or_label( _t('backend_meta_key_name'), 'key_name') !!}</label>
        {!! Form::text('key_name', null, ['class' => 'form-control', 'id' => 'key_name', 'placeholder' => _t('backend_meta_key_name')]) !!}
    </div>
    <div class="form-group">
        <label for="value">{!! error_or_label( _t('backend_meta_value'), 'value') !!}</label>
        {!! Form::text('value', null, ['class' => 'form-control', 'id' => 'value', 'placeholder' => _t('backend_meta_value')]) !!}
    </div>
    <button type="submit" class="btn btn-default _r2">{{ _t('backend_common_save') }}</button>
{!! Form::close() !!}

@stop