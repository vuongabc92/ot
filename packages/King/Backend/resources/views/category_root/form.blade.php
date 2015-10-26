@extends('backend::layouts._backend', ['active' => 'category-root'])

@section('title')
    @if($category_root->id !== null) 
        {{ _t('backend_cr') }} > {{ _t('backend_common_edit') }} |
    @else
        {{ _t('backend_cr') }} > {{ _t('backend_common_add') }} |
    @endif
@stop

@section('content')

<h3 class="_tg6 _fs20 add-title">{{ _t('backend_cr_new') }}</h3>
<hr />
{!! Form::model($category_root, ['url' => route('backend_cr_save'), 'role' => 'form']) !!}
    @if($category_root->id !== null) {!! Form::hidden('id', $category_root->id) !!} @endif
    <div class="form-group">
        <label for="name">{!! error_or_label( _t('backend_cr_name'), 'name') !!}</label>
        {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name', 'placeholder' => _t('backend_cr_name')]) !!}
    </div>
    <div class="form-group">
        <label for="slug">{!! error_or_label( _t('backend_cr_slug'), 'slug') !!}</label>
        {!! Form::text('slug', null, ['class' => 'form-control', 'id' => 'slug', 'placeholder' => _t('backend_cr_slug')]) !!}
    </div>
    <button type="submit" class="btn btn-default _r2">{{ _t('backend_common_save') }}</button>
{!! Form::close() !!}

@stop