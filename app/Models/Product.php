<?php

namespace App\Models;

class Product extends Base
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * Validation rules
     *
     * @return array
     */
    public function rules() {
        return [
            //'category_id' => 'required|exists:category_one,id',
            'category_id' => 'required|exists:category_two,id',
            //'category_id' => 'required|exists:category_three,id',
            'name'        => 'required|max:250',
            'slug'        => 'max:250|unique:products,slug',
            'image'       => 'required|image',
            'price'       => 'required|numeric',
            'old_price'   => 'numeric',
            'weight'      => 'numeric',
        ];
    }

    /**
     * Validation rule messages
     *
     * @return array
     */
    public function messages() {
        return [
            'category_id.required' => _t('backend_p_msg_catreq'),
            'category_id.exists'   => _t('backend_p_msg_catexi'),
            'name.required'        => _t('backend_p_msg_namreq'),
            'name.max'             => _t('backend_p_msg_nammax'),
            'slug.required'        => _t('backend_p_msg_slureq'),
            'slug.max'             => _t('backend_p_msg_slumax'),
            'slug.unique'          => _t('backend_p_msg_sluuni'),
            'image.required'       => _t('backend_p_msg_imgreq'),
            'image.image'          => _t('backend_p_msg_imgimg'),
            'price.required'       => _t('backend_p_msg_prireq'),
            'price.numeric'        => _t('backend_p_msg_prinum'),
            'old_price.numeric'    => _t('backend_p_msg_oldprinum'),
            'weight.numeric'       => _t('backend_p_msg_weinum'),
        ];
    }

    /**
     * Category One
     *
     * @return App\Models\CategoryOne
     */
    public function categoryOne() {
        return $this->belongsTo('App\Models\CategoryOne');
    }

    /**
     * Category Two
     *
     * @return App\Models\CategoryTwo
     */
    public function categoryTwo() {
        return $this->belongsTo('App\Models\CategoryTwo');
    }

    /**
     * Category Three
     *
     * @return App\Models\CategoryThree
     */
    public function categoryThree() {
        return $this->belongsTo('App\Models\CategoryThree');
    }
}
