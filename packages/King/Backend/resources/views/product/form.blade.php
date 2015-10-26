@extends('backend::layouts._backend', ['active' => 'product'])

@section('title')
    @if($product->id !== null) 
        {{ _t('backend_products') }} > {{ _t('backend_common_edit') }} |
    @else
        {{ _t('backend_products') }} > {{ _t('backend_common_add') }} |
    @endif
@stop

@section('content')

<h3 class="_tg6 _fs20 add-title">{{ _t('backend_product_new') }}</h3>
<hr />
{!! Form::model($product, ['url' => route('backend_product_save'), 'role' => 'form', 'files' => true]) !!}
    @if($product->id !== null) {!! Form::hidden('id', $product->id) !!} @endif
    <div class="form-group">
        <label for="category_id">{!! error_or_label( _t('backend_product_category'), 'category_id') !!}</label>
        {!! Form::select('category_id', $categories, $product->category_id, ['class' => 'form-control', 'id' => 'category_id', 'placeholder' => _t('backend_product_category')]) !!}
    </div>
    <div class="form-group">
        <label for="name">{!! error_or_label( _t('backend_product_name'), 'name') !!}</label>
        {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name', 'placeholder' => _t('backend_product_name')]) !!}
    </div>
<!--    if($product->id !== null)
    <div class="form-group">
        <label for="slug">{!! error_or_label( _t('backend_product_slug'), 'slug') !!}</label>
        {!! Form::text('slug', null, ['class' => 'form-control', 'id' => 'slug', 'placeholder' => _t('backend_product_slug')]) !!}
    </div>
    endif-->
    <div class="form-group">
        <label for="price">{!! error_or_label( _t('backend_product_price'), 'price') !!}</label>
        {!! Form::text('price', null, ['class' => 'form-control', 'id' => 'name', 'placeholder' => _t('backend_product_price')]) !!}
    </div>
    <div class="form-group">
        <label for="image">{!! error_or_label( _t('backend_product_image'), 'image') !!}</label>
        @set $images = json_decode($product->image)
        @if($images !== null && check_file($image_path . $images->small))
            <img src="{{ asset($image_path . $images->small) }}" class="product-image img-responsive _r2"/>
        @endif
        <div class="_mt10">
            {!! Form::file('image', ['class' => '', 'id' => 'image', 'accept' => 'image/*']) !!}
        </div>
    </div>
    <div class="form-group">
        <label for="_tinymce">{!! error_or_label( _t('backend_product_content'), 'content') !!}</label>
        {!! Form::textarea('content', null, ['class' => 'form-control', 'id' => '_tinymce', 'placeholder' => _t('backend_product_content')]) !!}
    </div>
    <button type="submit" class="btn btn-default _r2">{{ _t('backend_common_save') }}</button>
{!! Form::close() !!}

@stop