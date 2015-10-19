@extends('backend::layouts._backend')

@section('content')

<h3 class="_tg6 _fs20 add-title">{{ _t('backend_user_new') }}</h3>
<hr />
{!! Form::model($user, ['url' => route('backend_user_save'), 'role' => 'form', 'files' => true]) !!}
    @if($user->id !== null) {!! Form::hidden('id', $user->id) !!} @endif
    <div class="form-group">
        <label for="username">{!! error_or_label( _t('backend_auth_uname'), 'username') !!}</label>
        {!! Form::text('username', null, ['class' => 'form-control _r2', 'id' => 'username', 'placeholder' => _t('backend_auth_uname')]) !!}
    </div>
    <div class="form-group">
        <label for="email">{!! error_or_label( _t('backend_auth_email'), 'email') !!}</label>
        {!! Form::text('email', null, ['class' => 'form-control _r2', 'id' => 'email', 'placeholder' => _t('backend_auth_email')]) !!}
    </div>
    <div class="form-group">
        <label for="password">{!! error_or_label( _t('backend_auth_pass'), 'password') !!}</label>
        {!! Form::password('password', ['class' => 'form-control _r2', 'id' => 'password', 'placeholder' => _t('backend_auth_pass')]) !!}
    </div>
    <div class="form-group">
        <label for="role_id">{!! error_or_label( _t('backend_role'), 'role_id') !!}</label>
        {!! Form::select('role_id', $roles, $user->role_id, ['class' => 'form-control _r2', 'id' => 'role_id']) !!}
    </div>  
    <div class="form-group">
        <label for="avatar">{!! error_or_label( _t('backend_user_avatar'), 'avatar') !!}</label>
        {!! Form::file('avatar', ['class' => 'form-control _r2', 'id' => 'avatar', 'accept' => 'image/*']) !!}
    </div>  
    <button type="submit" class="btn btn-default _r2">{{ _t('backend_common_save') }}</button>
{!! Form::close() !!}

@stop