<!doctype html>
<html lang="en" class="no-js">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,700' rel='stylesheet' type='text/css'>

        <link rel="stylesheet" href="{{ asset('packages/king/backend/css/reset.css') }}"> <!-- CSS reset -->
        <link rel="stylesheet" href="{{ asset('packages/king/backend/css/bootstrap.css') }}"> <!-- CSS reset -->
        <link rel="stylesheet" href="{{ asset('packages/king/backend/css/font-awesome.css') }}"> <!-- CSS reset -->
        <link rel="stylesheet" href="{{ asset('packages/king/backend/css/common.css') }}"> <!-- Resource style -->
        <link rel="stylesheet" href="{{ asset('packages/king/backend/css/style.css') }}"> <!-- Resource style -->
        <script src="{{ asset('packages/king/backend/js/modernizr.js') }}"></script> <!-- Modernizr -->

        <title>{{ _t('backend_auth_login') }} | King Elephant</title>
    </head>
    <body class="auth">

        <div class="container-fluid">
            <div class="auth-container _p0">
                <form class="_fwfl" action="{{ route('backend_login') }}" method="POST">
                    {!! csrf_field() !!}
                    <h3>
                        {{ _t('backend_auth_login') }}
                        @if( ! $pass)
                            <b class="_fs13 _tr5">{{ _t('backend_auth_fails') }}</b>
                        @endif
                    </h3>
                    <div class="_fwfl auth-form-group">
                        <input type="text" name="username" autocomplete="off" maxlength="32" class="_fwfl _r2 auth-field" placeholder="{{ _t('backend_auth_uname') }}"/>
                    </div>
                    <div class="_fwfl auth-form-group">
                        <input type="password" name="password" maxlength="60" class="_fwfl _r2 auth-field" placeholder="{{ _t('backend_auth_pass') }}"/>
                    </div>
                    <div class="_fwfl"><label><input type="checkbox" class="_fl" name="remember" value="1"/> <b class="_fl _fs13 _mt1 _ml5 _tg7">{{ _t('backend_auth_reme') }}</b></label></div>
                    <div class="_fwfl auth-form-group">
                        <button type="submit" class="_fwfl _btn _btn-blue btn auth-btn"><i class="fa fa-arrow-right"></i></button>
                    </div>
                    <div class="_fwfl auth-form-group">
                        <a href="#">{{ _t('backend_auth_lostpass') }}</a>
                    </div>
                </form>
            </div>
        </div>

        <script src="{{ asset('packages/king/backend/js/jquery-2.1.4.js') }}"></script>
        <script src="{{ asset('packages/king/backend/js/bootstrap.js') }}"></script>
        <!-- Resource jQuery -->
    </body>
</html>