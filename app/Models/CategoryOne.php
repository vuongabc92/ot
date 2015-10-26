<?php

namespace App\Models;

class CategoryOne extends Base
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'category_one';

    /**
     * Validation rules
     *
     * @return array
     */
    public function rules() {
        return [
            'name'  => 'required|max:250',
            'slug'  => 'max:250|unique:category_one,slug',
            'image' => 'image',

        ];
    }

    /**
     * Validation rule messages
     *
     * @return array
     */
    public function messages() {
        return [
            'name.required' => _t('backend_co_msg_nareq'),
            'name.max'      => _t('backend_co_msg_namax'),
            'image.image'   => _t('backend_co_msg_imgimage'),
        ];
    }

    /**
     * Category Root
     *
     * @return App\Models\CategoryRoot
     */
    public function categoryRoot() {
        return $this->belongsTo('App\Models\CategoryRoot');
    }
}
