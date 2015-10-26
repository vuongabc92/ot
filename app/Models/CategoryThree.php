<?php

namespace App\Models;

class CategoryThree extends Base
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'category_three';

    /**
     * Validation rules
     *
     * @return array
     */
    public function rules() {
        return [
            'category_two_id' => 'required|exists:category_two,id',
            'name'            => 'required|max:250',
            'slug'            => 'max:250|unique:category_three,slug',
            'image'           => 'image',
        ];
    }

    /**
     * Validation rule messages
     *
     * @return array
     */
    public function messages() {
        return [
            'category_one_id.required' => _t('backend_cth_msg_ctreq'),
            'category_one_id.exists'   => _t('backend_cth_msg_ctexi'),
            'name.required'            => _t('backend_cth_msg_nareq'),
            'name.max'                 => _t('backend_cth_msg_namax'),
            'image.image'              => _t('backend_cth_msg_imgimage'),
        ];
    }

    /**
     * Category Two
     *
     * @return App\Models\CategoryTwo
     */
    public function categoryTwo() {
        return $this->belongsTo('App\Models\CategoryTwo');
    }
}
