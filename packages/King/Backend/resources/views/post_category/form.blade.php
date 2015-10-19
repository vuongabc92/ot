@extends('backend::layouts._backend')

@section('content')

<h3 class="_tg6 _fs20 add-title">{{ _t('backend_pc_new') }}</h3>
<hr />
{!! Form::model($post_category, ['url' => route('backend_pc_save'), 'role' => 'form']) !!}
    @if($post_category->id !== null) {!! Form::hidden('id', $post_category->id) !!} @endif
    <div class="form-group">
        <label for="name">{!! error_or_label( _t('backend_pc_name'), 'name') !!}</label>
        {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name', 'placeholder' => _t('backend_pc_name')]) !!}
    </div>
    <div class="form-group">
        <label for="role">{!! error_or_label( _t('backend_pc_slug'), 'role') !!}</label>
        {!! Form::text('slug', null, ['class' => 'form-control', 'id' => 'role', 'placeholder' => _t('backend_pc_slug')]) !!}
    </div>
    <button type="submit" class="btn btn-default _r2">{{ _t('backend_common_save') }}</button>
{!! Form::close() !!}

@stop