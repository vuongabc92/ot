@extends('backend::layouts._backend')

@section('content')

<h3 class="_tg6 _fs20 add-title">{{ _t('backend_cth_new') }}</h3>
<hr />
{!! Form::model($category_three, ['url' => route('backend_cth_save'), 'role' => 'form', 'files' => true]) !!}
    @if($category_three->id !== null) {!! Form::hidden('id', $category_three->id) !!} @endif
    <div class="form-group">
        <label for="category_two_id">{!! error_or_label( _t('backend_cth_ct'), 'category_two_id') !!}</label>
        {!! Form::select('category_two_id', $category_two, $category_three->category_two_id, ['class' => 'form-control _r2', 'id' => 'category_two_id']) !!}
    </div>
    <div class="form-group">
        <label for="name">{!! error_or_label( _t('backend_cth_name'), 'name') !!}</label>
        {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name', 'placeholder' => _t('backend_cth_name')]) !!}
    </div>
    <div class="form-group">
        <label for="slug">{!! error_or_label( _t('backend_cth_image'), 'image') !!}</label>
        @if(check_file($image_path . $category_three->image))
            <img src="{{ asset($image_path . $category_three->image) }}" class="image-image img-responsive _r2"/>
        @endif
        <div class="_mt10">
            {!! Form::file('image', ['class' => '', 'id' => 'image', 'accept' => 'image/*']) !!}
        </div>
    </div>
    <hr />
    <button type="submit" class="btn btn-default _r2">{{ _t('backend_common_save') }}</button>
{!! Form::close() !!}

@stop