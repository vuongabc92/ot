@extends('backend::layouts._backend')

@section('content')

<h3 class="_tg6 _fs20 add-title">{{ _t('backend_role_new') }}</h3>
<hr />
{!! Form::model($role, ['url' => route('backend_role_save'), 'role' => 'form']) !!}
    @if($role->id !== null) {!! Form::hidden('id', $role->id) !!} @endif
    <div class="form-group">
        <label for="name">{!! error_or_label( _t('backend_role_name'), 'name') !!}</label>
        {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name', 'placeholder' => _t('backend_role_name')]) !!}
    </div>
    <div class="form-group">
        <label for="role">{!! error_or_label( _t('backend_role'), 'role') !!}</label>
        {!! Form::text('role', null, ['class' => 'form-control', 'id' => 'role', 'placeholder' => _t('backend_role')]) !!}
    </div>
    <button type="submit" class="btn btn-default _r2">{{ _t('backend_common_save') }}</button>
{!! Form::close() !!}

@stop