@extends('backend::layouts._backend', ['active' => 'product'])

@section('title')
    {{ _t('backend_products') }} |
@stop

@section('content')

<h3 class="_tg6 _fs20">{{ _t('backend_product_list') }}</h3>
<hr />
@if(session()->has('success'))
    <div class="alert alert-success _r2">{{ session()->get('success') }}</div>
@endif
@if(session()->has('error'))
    <div class="alert alert-danger _r2">{{ session()->get('error') }}</div>
@endif
<form method="POST" action="{{ route('backend_product_delete_selected') }}">
    <div class="_mb10">
        <button class="btn btn-danger _r2 kbtn" type="submit">{{ _t('backend_common_delete') }}</button>
        <a class="btn btn-default _r2 kbtn" href="{{ route('backend_product_add') }}">{{ _t('backend_product_new') }}</a>
    </div>
    {{ csrf_field() }}
    <table class="table table-bordered table-hover table-responsive table-striped">
        <thead>
            <tr>
                <th><input type="checkbox" id="check-all" /></th>
                <th>{{ _t('backend_product_image') }}</th>
                <th>{{ _t('backend_product_name') }}</th>
                <th width="50px">{{ _t('backend_common_status') }}</th>
                <th width="120px">{{ _t('backend_common_last') }}</th>
                <th width="130px">{{ _t('backend_common_actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @set $i = 0
            @foreach($lists as $product)
                @set $i = $i + 1
                @set $images = json_decode($product->image)
            <tr>
                <td><input type="checkbox" class="list-checkbox check-{{ $product->id }}" value="{{ $product->id }}" name="list_checked[]"/></td>
                <td>
                    @if($images !== null && ! check_file($image_path . $images->small))
                        <span class="default-image default-product-img _r2 fa fa-image"></span>
                    @else
                        <img src="{{ asset($image_path . $images->small) }}" class="product-image img-responsive _r2"/>
                    @endif
                </td>
                <td>{{ $product->name }}</td>
                <td>
                    @if($product->is_active)
                    <a class="label label-success _fs11 _r2" href="{{ route('backend_product_active', ['id' => $product->id]) }}">{{ _t('backend_common_active') }}</a>
                    @else
                    <a class="label label-danger _fs11 _r2" href="{{ route('backend_product_active', ['id' => $product->id]) }}">{{ _t('backend_common_disable') }}</a>
                    @endif
                </td>
                <td>{{ time_format($product->updated_at, 'd/m/Y') }}</td>
                <td>
                    <a href="{{ route('backend_product_edit', ['id' => $product->id]) }}" class="btn btn-warning btn-sm _r2">{{ _t('backend_common_edit') }}</a>
                    <a href="{{ route('backend_product_delete', ['id' => $product->id, 'token' => csrf_token()]) }}" class="btn btn-danger btn-sm _r2" onclick="return confirm('{{ _t('backend_product_delete_one') }}')">{{ _t('backend_common_delete') }}</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</form>
<div class="_fwfl">
    <a class="btn btn-default _r2 kbtn" href="{{ route('backend_product_add') }}">{{ _t('backend_product_new') }}</a>
</div>
@stop